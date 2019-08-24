<?php

namespace Folk\Entities;

use Folk\Admin;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use Folk\SearchQuery;

/**
 * Interface used by all entities.
 */
interface EntityInterface
{
    /**
     * Constructor.
     *
     * @param string $name
     * @param Admin  $admin
     */
    public function __construct(string $name, Admin $admin);

    /**
     * Returns the entity name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * List the entity rows.
     *
     * @param SearchQuery $search
     *
     * @return array The rows data
     */
    public function search(SearchQuery $search): array;

    /**
     * Creates a new entity row.
     *
     * @param array $data The entity data
     *
     * @return mixed The entity id
     */
    public function create(array $data);

    /**
     * Read the data of an entity row.
     *
     * @param mixed $id The entity id
     *
     * @return array The entity data
     */
    public function read($id): array;

    /**
     * Update the data of an entity row.
     *
     * @param mixed $id   The entity id
     * @param array $data The entity data
     */
    public function update($id, array $data);

    /**
     * Delete an entity row.
     *
     * @param mixed $id The entity id
     */
    public function delete($id);

    /**
     * Returns the data scheme used by this entity.
     *
     * @param FormatFactory $factory
     *
     * @return Group
     */
    public function getScheme(FormatFactory $factory): Group;

    /**
     * Returns the label of a row.
     *
     * @param mixed $id   The entity id
     * @param array $data The entity data
     *
     * @return string
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
     *
     * @return array|null
     */
    public function getActions($id): array;
}
