<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use SimpleCrud\Table;
use SimpleCrud\Row;
use SimpleCrud\Scheme\Scheme;
use SimpleCrud\Queries\Query;

abstract class SimpleCrud extends AbstractEntity
{
    protected $searchFields;
    protected $firstField;

    /**
     * Returns the simple-crud table.
     * 
     * @return Table
     */
    abstract protected function getTable(): Table;

    /**
     * Generates the query to search rows.
     * 
     * @param SearchQuery $search
     * 
     * @return Query
     */
    protected function getQuery(SearchQuery $search): Query
    {
        $table = $this->getTable();

        $query = $table->select();

        //Filter by id
        if (count($search->getIds())) {
            $query->byId($search->getIds());
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
            $query->orderBy("`{$table->getName()}`.`id`", 'DESC');
        } else {
            foreach ($orderBy as $field => $direction) {
                $query->orderBy("`{$table->getName()}`.`{$field}`", $direction);
            }
        }

        //Filter by words
        foreach ($search->getWords() as $k => $word) {
            $where = [];

            foreach ($this->searchFields as $field) {
                $where[] = "(`{$table->getName()}`.`{$field}` LIKE :w{$k})";
            }

            $query->where(implode(' OR ', $where), [":w{$k}" => "%{$word}%"]);
        }

        //Filter by relations
        $db = $table->getDatabase();

        foreach ($search->getConditions() as $name => $value) {
            $related = $db->$name
                ->select()
                ->by('id', $value)
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
            $result[$row->id] = $row->toArray();
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

        $row = $table[$id];

        if (empty($row)) {
            return [];
        }

        $relations = $table->getScheme()['relations'];
        $array = $row->toArray();

        foreach ($relations as $name => $relation) {
            if ($relation[0] === Scheme::HAS_MANY || $relation[0] === Scheme::HAS_MANY_TO_MANY) {
                $array[$name] = array_values($row->$name->id);
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
            foreach (array_keys($this->getTable()->getScheme()['fields']) as $field) {
                if ($field !== 'id') {
                    return $this->firstField = $field;
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
        $scheme = $table->getScheme();

        foreach ($data as $name => $value) {
            if (isset($scheme['fields'][$name])) {
                $row->$name = $value;
            }
        }

        foreach ($data as $name => $value) {
            if (isset($scheme['relations'][$name])) {
                $unrelated = $row->$name()
                    ->where("`{$name}`.`id` NOT IN (:ids)", [':ids' => $value])
                    ->run();

                foreach ($unrelated as $r) {
                    $row->unrelate($r);
                }

                $rows = $db->$name->select()->by('id', $value)->run();

                foreach ($rows as $r) {
                    $row->relate($r);
                }
            }
        }

        $row->save();
    }
}
