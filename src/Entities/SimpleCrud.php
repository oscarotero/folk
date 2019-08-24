<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use SimpleCrud\Queries\Query;
use SimpleCrud\Row;
use SimpleCrud\Table;

abstract class SimpleCrud extends AbstractEntity
{
    protected $searchFields;
    protected $firstField;

    /**
     * Returns the simple-crud table.
     */
    abstract protected function getTable(): Table;

    /**
     * Generates the query to search rows.
     */
    protected function getQuery(SearchQuery $search): Query
    {
        $table = $this->getTable();

        $query = $table->select();

        //Filter by id
        if (count($search->getIds())) {
            $query->where('id IN', $search->getIds());
        }

        if ($search->getPage() !== null) {
            $limit = $search->getLimit();

            $query->offset(($search->getPage() * $limit) - $limit)->limit($limit);
        }

        if ($this->searchFields === null) {
            $this->searchFields = [$this->getFirstField()];
        }

        $orderBy = $search->getSort();

        if (empty($orderBy)) {
            $query->orderBy("{$table->id} DESC");
        } else {
            foreach ($orderBy as $field => $direction) {
                $query->orderBy("{$table->$field} {$direction}");
            }
        }

        //Filter by words
        foreach ($search->getWords() as $word) {
            $query->where('(');
            $like = "%{$word}%";

            foreach ($this->searchFields as $k => $field) {
                if ($k !== 0) {
                    $query->catWhere(' OR ');
                }

                $query->catWhere("{$table->$field} LIKE ", $like);
            }

            $query->catWhere(')');
        }

        //Filter by relations
        $db = $table->getDatabase();

        foreach ($search->getConditions() as $name => $value) {
            $related = $db->$name
                ->select()
                ->whereEquals(['id' => $value])
                ->run();

            $query->relatedWith($related);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function search(SearchQuery $search): array
    {
        $result = [];

        foreach ($this->getQuery($search)->run() as $row) {
            $result[$row->id] = $row->toArray(true);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $row = $this->getTable()->create();

        $this->save($row, $data);

        return $row->id;
    }

    /**
     * {@inheritdoc}
     */
    public function read($id): array
    {
        $table = $this->getTable();
        $db = $table->getDatabase();

        $row = $table[$id];

        if (empty($row)) {
            return [];
        }

        $array = $row->toArray(true);
        $foreignKey = $table->getForeignKey();

        foreach ($db->getScheme()->getTables() as $tableName) {
            $table2 = $db->{$tableName};

            //Has many OR has many to many
            if ($table2->getJoinField($table) || $table->getJoinTable($table2)) {
                $array[$tableName] = array_values($row->$tableName->id);
                continue;
            }
        }

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $row = $this->getTable()[$id];

        $this->save($row, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $table = $this->getTable();

        unset($table[$id]);
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel($id, array $data): string
    {
        return "{$id} - ".$data[$this->getFirstField()];
    }

    /**
     * {@inheritdoc}
     */
    protected function getFirstField(): string
    {
        if ($this->firstField === null) {
            foreach ($this->getTable()->getFields() as $field) {
                if ($field->getName() !== 'id') {
                    return $this->firstField = $field->getName();
                }
            }
        }

        return $this->firstField;
    }

    /**
     * Save the data in the database.
     *
     * @param Row   $row
     * @param array $data
     */
    protected function save(Row $row, array $data)
    {
        $table = $this->getTable();
        $db = $table->getDatabase();
        $tables = $db->getScheme()->getTables();
        $relations = [];

        foreach ($data as $name => $value) {
            if (isset($table->$name)) {
                $row->$name = $value;
                continue;
            }

            if (in_array($name, $tables)) {
                $relations[$name] = (array) $value;
            }
        }

        foreach ($relations as $name => $ids) {
            $table2 = $db->$name;
            $related = $row->$name;

            foreach ($related as $id => $r) {
                if (!in_array($id, $ids)) {
                    $row->unrelate($r);
                }
            }

            foreach ($ids as $id) {
                if ($id && !isset($related[$id])) {
                    if ($r = $table2[$id]) {
                        $row->relate($r);
                    }
                }
            }
        }

        $row->save();
    }
}
