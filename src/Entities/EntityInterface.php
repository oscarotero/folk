<?php

namespace Folk\Entities;

use Folk\SearchQuery;
use FormManager\Form;

/**
 * Interface used by all entities.
 */
interface EntityInterface
{
    /**
     * Returns the entity title
     */
    public function getTitle(): string;

    /**
     * Returns the entity description
     */
    public function getDescription(): string;

    /**
     * Returns the entity icon
     */
    public function getIcon(): string;

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
    public function getScheme(): array;

    /**
     * Returns the label of a row.
     *
     * @param mixed $id
     */
    public function getLabel($id, array $data): string;

    /**
     * Returns actions buttons from an entity.
     *
     * @param mixed $id The entity id
     *
     * @return Form[]
     */
    public function getActions($id): array;
}
