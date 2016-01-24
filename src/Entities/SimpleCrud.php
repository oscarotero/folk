<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use SimpleCrud\SimpleCrud as SimpleCrudDatabase;

abstract class SimpleCrud extends AbstractEntity implements EntityInterface
{
    protected $searchFields;

    /**
     * Returns the simple-crud entity
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

        $db = $entity->getDb();

        foreach ($search->getConditions() as $name => $value) {
            $related = $db->get($name)->select()->by('id', $value)->all();
            $query->relatedWith($related);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function search(SearchQuery $search = null)
    {
        $query = $this->getQuery($search, $page);

        $result = $query->all()->toArray(true);

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
        return $this->getDbEntity()->create($data)->save(false, true)->id;
    }

    /**
     * {@inheritdoc}
     */
    public function read($id)
    {
        $entity = $this->getDbEntity();

        $row = $entity[$id];

        return $row ? $row->toArray() : null;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $entity = $this->getDbEntity();

        return $entity[$id]->set($data)->save(false, true)->toArray();
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
}
