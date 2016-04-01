<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use SimpleCrud\Row;
use FilesystemIterator;
use RecursiveDirectoryIterator;

abstract class FileEntity extends AbstractEntity implements EntityInterface
{
    protected $extension;

    /**
     * Returns the base path.
     * 
     * @return string
     */
    abstract protected function getBasePath();

    protected function getIterator()
    {
        return new RecursiveDirectoryIterator($this->getBasePath(), FilesystemIterator::SKIP_DOTS);
    }

    /**
     * {@inheritdoc}
     */
    public function search(SearchQuery $search = null)
    {
        $result = [];
        $words = $search->getWords();
        $start = strlen($this->getBasePath()) + 1;
        $length = -strlen($this->extension) - 1;

        foreach ($this->getIterator() as $file) {
            if (!$file->isFile() || $file->getExtension() !== $this->extension) {
                continue;
            }

            $id = substr($file->getPathname(), $start, $length);

            foreach ($words as $word) {
                if (strpos($id, $word) === false) {
                    continue;
                }
            }

            $result[$id] = $this->parse(file_get_contents($file->getPathname()));
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $file = $this->getFilePath($this->getId($data));
        $source = $this->stringify($data);

        file_put_contents($file, $source);

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function read($id)
    {
        $file = $this->getFilePath($id);

        return $this->parse(file_get_contents($file));
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $file = $this->getFilePath($id);
        $source = $this->stringify($data);

        file_put_contents($file, $source);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $file = $this->getFilePath($id);

        unlink($file);
    }

    /**
     * Calculate the id of a new row.
     * 
     * @param array $data
     * 
     * @return string
     */
    protected function getId(array $data)
    {
        return uniqid();
    }

    /**
     * Returns the path of a file.
     * 
     * @return string
     */
    protected function getFilePath($filename)
    {
        return $this->getBasePath()."/{$filename}.{$this->extension}";
    }

    /**
     * Transform the data to a string.
     * 
     * @param array $data
     * 
     * @return string
     */
    abstract protected function stringify(array $data);

    /**
     * Transform the string to an array.
     * 
     * @param string $source
     * 
     * @return array
     */
    abstract protected function parse($source);
}
