<?php

namespace Folk\Entities;

use Folk\Admin;
use Folk\SearchQuery;
use Folk\Schema\RowInterface;

/**
 * Interface used by all entities.
 */
interface EntityInterface
{
    public function __construct(string $name, Admin $admin);

    /**
     * Returns the entity name
     */
    public function getName(): string;

    /**
     * List the entity rows.
     */
    public function search(SearchQuery $search = null): array;

    /**
     * Creates a new entity row.
     *
     * @return mixed The id
     */
    public function create(array $data);

    /**
     * Read the data of a row.
     *
     * @param mixed $id
     */
    public function read($id): array;

    /**
     * Update the data of an entity row.
     *
     * @param mixed $id
     */
    public function update($id, array $data): array;

    /**
     * Delete an entity row.
     *
     * @param mixed $id
     */
    public function delete($id): void;

    /**
     * Returns the data scheme used by this entity.
     */
    public function getRow(): RowInterface;

    /**
     * Returns the label of a row.
     *
     * @param mixed $id
     */
    public function getLabel($id, array $data): string;

    /**
     * Returns action buttons from an entity.
     * Example: prev / next links, preview, etc
     *
     * Each action is an array with the following keys options
     * - label (string, required)
     * - url (string, required)
     * - method (GET by default)
     * - data (array)
     * - icon (string)
     * - target (string)
     *
     * @param mixed $id The entity id
     */
    public function getActions($id): array;
}
