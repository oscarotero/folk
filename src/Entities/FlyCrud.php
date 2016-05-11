<?php

namespace App\Admin;

use Folk\Entities\EntityInterface;
use Folk\Entities\AbstractEntity;
use Folk\SearchQuery;
use FlyCrud\Document;

abstract class FlyCrudEntity extends AbstractEntity implements EntityInterface
{
    /**
     * Returns the fly-crud repository.
     * 
     * @return \FlyCrud\Repository
     */
    abstract protected function getRepository();

    /**
     * {@inheritdoc}
     */
    public function search(SearchQuery $search)
    {
        $result = [];

        foreach ($this->getRepository()->getAll() as $id => $document) {
            $result[$id] = $document->getData();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $repository = $this->getRepository();
        $data = $this->beforeSave($data);
        $document = new Document($data);
        $document->setId($this->generateId($document));

        $repository->save($document);

        return $document->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function read($id)
    {
        $repository = $this->getRepository();

        return $repository->get($id)->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $repository = $this->getRepository();

        $document = $repository->get($id);
        $data = $this->beforeSave($data);
        $document->setData($data);

        $repository->save($document);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $repository = $this->getRepository();

        $document = $repository->get($id);
        $repository->delete($document);
    }

    /**
     * Returns the id for the new documents
     * Useful to customize the id before save.
     * 
     * @param Document $document
     * 
     * @return string
     */
    protected function generateId(Document $document)
    {
        return $document->getId();
    }
}
