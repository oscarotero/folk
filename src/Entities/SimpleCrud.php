<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use SimpleCrud\Row;
use SimpleCrud\Scheme\Scheme;

abstract class SimpleCrud extends AbstractEntity implements EntityInterface
{
    protected $searchFields;

    /**
     * Returns the simple-crud entity.
     * 
     * @return SimpleCrud\Entity
     */
    abstract protected function getDbEntity();

    protected function getQuery(SearchQuery $search = null, &$page = null)
    {
        $entity = $this->getDbEntity();

        if ($search === null) {
            return $entity->select()->orderBy('id DESC');
        }

        $page = $search->getPage() ?: 1;

        $query = $entity->select()
            ->orderBy("`{$entity->name}`.`id` DESC")
            ->offset(($page * 50) - 50)
            ->limit(50);

        if ($this->searchFields === null) {
            $this->searchFields = [$this->getFirstField()];
        }

        foreach ($search->getWords() as $k => $word) {
            foreach ($this->searchFields as $field) {
                $query->where("`{$entity->name}`.`{$field}` LIKE :w{$k}", [":w{$k}" => "%{$word}%"]);
            }
        }

        $db = $entity->getDatabase();

        foreach ($search->getConditions() as $name => $value) {
            $related = $db->$name->select()->by('id', $value)->run();
            $query->relatedWith($related);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function search(SearchQuery $search = null)
    {
        $result = [];

        foreach ($this->getQuery($search, $page)->run() as $row) {
            $result[$row->id] = $row->toArray();
        }

        if ($search && (count($result) === 50 || $page > 1)) {
            $search->setPage($page);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $row = $this->getDbEntity()->create();

        $this->save($row, $data);

        return $row->id;
    }

    /**
     * {@inheritdoc}
     */
    public function read($id)
    {
        $entity = $this->getDbEntity();

        $row = $entity[$id];

        if (empty($row)) {
            return;
        }

        $relations = $entity->getScheme()['relations'];
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
        $row = $this->getDbEntity()[$id];

        $this->save($row, $data);

        return $row->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $entity = $this->getDbEntity();

        unset($entity[$id]);
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
        $entity = $this->getDbEntity();

        foreach (array_keys($entity->fields) as $key) {
            if ($key !== 'id') {
                return $key;
            }
        }
    }

    protected function save(Row $row, array $data)
    {
        $entity = $this->getDbEntity();
        $db = $entity->getDatabase();
        $scheme = $entity->getScheme();

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
