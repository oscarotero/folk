<?php

namespace Folk\Entities\File;

use Folk\SearchQuery;
use Folk\Entities\Entity;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use Exception;

abstract class File extends Entity
{
    protected $extension;

    /**
     * Returns the base path.
     */
    abstract protected function getBasePath(): string;

    protected function getIterator(): RecursiveDirectoryIterator
    {
        return new RecursiveDirectoryIterator($this->getBasePath(), FilesystemIterator::SKIP_DOTS);
    }

    public function search(SearchQuery $search = null): array
    {
        $result = [];
        $terms = $search->getTerms();
        $start = strlen($this->getBasePath()) + 1;
        $length = -strlen($this->extension) - 1;
        $id = $search->getId();

        foreach ($this->getIterator() as $file) {
            if (!$file->isFile() || $file->getExtension() !== $this->extension) {
                continue;
            }

            //Filter by id
            $fileId = substr($file->getPathname(), $start, $length);

            if (!empty($id) && $id !== $fileId) {
                continue;
            }

            //Filter by terms
            $content = file_get_contents($file->getPathname());

            foreach ($terms as $term) {
                if (strpos($content, $term) === false) {
                    continue 2;
                }
            }

            $result[$fileId] = $this->parse($content);
        }

        if ($search->getPage() !== null) {
            $limit = $search->getLimit();
            $offset = ($search->getPage() * $limit) - $limit;

            $result = array_slice($result, $offset, $limit, true);
        }

        return $result;
    }

    public function create(array $data)
    {
        $id = $this->generateId($data);
        $file = $this->getFilePath($id);
        $source = $this->stringify($data);

        if (file_put_contents($file, $source) === false) {
            throw new Exception(sprintf('Data could not be saved in the file %s', $file));
        }

        return $id;
    }

    public function read($id): array
    {
        $file = $this->getFilePath($id);

        return $this->parse(file_get_contents($file));
    }

    public function update($id, array $data): array
    {
        $file = $this->getFilePath($id);
        $source = $this->stringify($data);

        if (file_put_contents($file, $source) === false) {
            throw new Exception(sprintf('Data could not be saved in the file %s', $file));
        }

        return $data;
    }

    public function delete($id): void
    {
        $file = $this->getFilePath($id);

        if (unlink($file) === false) {
            throw new Exception(sprintf('The file %s could not be deleted', $file));
        }
    }

    /**
     * Generate the id of a new row.
     */
    protected function generateId(array $data): string
    {
        $list = glob($this->getBasePath()."/*.{$this->extension}");

        return count($list) + 1;
    }

    /**
     * Returns the path of a file.
     */
    protected function getFilePath(string $filename): string
    {
        return $this->getBasePath()."/{$filename}.{$this->extension}";
    }

    /**
     * Transform the data to a string.
     */
    abstract protected function stringify(array $data): string;

    /**
     * Transform the string to an array.
     */
    abstract protected function parse(string $source): array;
}
