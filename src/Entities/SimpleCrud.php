<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use SimpleCrud\Row;
use SimpleCrud\Scheme\Scheme;

abstract class SimpleCrud extends AbstractEntity implements EntityInterface
{
    protected $searchFields;
    protected $firstField;

    /**
     * Returns the simple-crud table.
     * 
     * @return SimpleCrud\Table
     */
    abstract protected function getTable();

    protected function getQuery(SearchQuery $search)
    {
        $table = $this->getTable();

        $query = $table->select();

        if ($search->getPage() !== null) {
            $query
                ->offset(($search->getPage() * 50) - 50)
                ->limit(50);
        }

        if ($this->searchFields === null) {
            $this->searchFields = [$this->getFirstField()];
        }

        $orderBy = $search->getSort();

        if (!empty($orderBy) && isset($table->getScheme()['fields'][$orderBy])) {
            $query->orderBy("`{$table->name}`.`{$orderBy}`", $search->getDirection());
        } else {
            $query->orderBy("`{$table->name}`.`id`", 'DESC');
        }

        foreach ($search->getWords() as $k => $word) {
            foreach ($this->searchFields as $field) {
                $query->where("`{$table->name}`.`{$field}` LIKE :w{$k}", [":w{$k}" => "%{$word}%"]);
            }
        }

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
    public function search(SearchQuery $search)
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
    public function read($id)
    {
        $table = $this->getTable();

        $row = $table[$id];

        if (empty($row)) {
            return;
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

        return $row->toArray();
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
    public function getLabel($id, array $data)
    {
        return "{$id} - ".$data[$this->getFirstField()];
    }

    /**
     * {@inheritdoc}
     */
    protected function getFirstField()
    {
        if ($this->firstField === null) {
            $scheme = $this->getScheme();
            $this->firstField = key($scheme);
        }

        return $this->firstField;
    }

    protected function save(Row $row, array $data)
    {
        $table = $this->getTable();
        $db = $table->getDatabase();
        $scheme = $table->getScheme();

        foreach ($data as $name => $value) {
            if (isset($scheme['relations'][$name])) {
                $row->$name = $db->$name->select()->by('id', $value)->run();
            } else {
                $row->$name = $value;
            }
        }

        $row->save(true);
    }
}
