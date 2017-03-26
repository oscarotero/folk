<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use FlyCrud\Document;

abstract class FlyCrud extends AbstractEntity implements EntityInterface
{
    /**
     * Returns the fly-crud directory.
     * 
     * @return \FlyCrud\Directory
     */
    abstract protected function getDirectory();

    /**
     * {@inheritdoc}
     */
    public function search(SearchQuery $search): array
    {
        $result = [];

        foreach ($this->getDirectory()->getAllDocuments() as $id => $document) {
            $result[$id] = $document->getArrayCopy();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $document = new Document($data);
        $id = $this->generateId($document);
        $this->getDirectory()->saveDocument($id, $document);

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function read($id): array
    {
        return $this->getDirectory()->getDocument($id)->getArrayCopy();
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $this->getDirectory()->saveDocument($id, new Document($data));
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->getDirectory()->deleteDocument($id);
    }

    /**
     * Generate ids for the new documents
     * 
     * @param Document $document
     * 
     * @return string
     */
    protected function generateId(Document $document): string
    {
        return uniqid();
    }
}
