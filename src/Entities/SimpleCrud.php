<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use SimpleCrud\SimpleCrud as SimpleCrudDatabase;

abstract class SimpleCrud extends AbstractEntity
{
    protected $db;
    protected $entity;
    protected $searchFields;

    protected function setDatabase(SimpleCrudDatabase $database)
    {
        $this->db = $database;
        $this->entity = $this->db->get($this->name);
    }

    protected function getQuery(SearchQuery $search = null, &$page = null)
    {
        if ($search === null) {
            return $this->entity->select()->orderBy('id DESC');
        }

        $page = $search->getPage() ?: 1;

        $query = $this->entity->select()
            ->orderBy("`{$this->entity->name}`.`id` DESC")
            ->offset(($page * 50) - 50)
            ->limit(50);

        if ($this->searchFields === null) {
            $this->searchFields = [$this->getFirstField()];
        }

        foreach ($search->getWords() as $k => $word) {
            foreach ($this->searchFields as $field) {
                $query->where("`{$this->entity->name}`.`{$field}` LIKE :w{$k}", [":w{$k}" => "%{$word}%"]);
            }
        }

        foreach ($search->getConditions() as $name => $value) {
            $related = $this->db->get($name)->select()->by('id', $value)->all();
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
        return $this->entity->create($data)->save(false, true)->id;
    }

    /**
     * {@inheritdoc}
     */
    public function read($id)
    {
        $row = $this->entity[$id];

        return $row ? $row->toArray() : null;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        return $this->entity[$id]->set($data)->save(false, true)->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        unset($this->entity[$id]);
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
        foreach (array_keys($this->entity->fields) as $key) {
            if ($key !== 'id') {
                return $key;
            }
        }
    }
}
