<?php

namespace Folk;

/**
 * Class to manage a query to search rows.
 */
class SearchQuery
{
    protected $limit = 50;
    protected $page;
    protected $id;
    protected $conditions = [];
    protected $terms = [];
    protected $sort = [];

    public function __construct(array $query = [])
    {
        if (!empty($query['query'])) {
            $this->setQuery($query['query']);
        }

        if (!empty($query['page'])) {
            $this->setPage($query['page']);
        }

        if (!empty($query['sort'])) {
            $this->setSort($query['sort']);
        }
    }

    /**
     * Set the a query.
     */
    public function setQuery(string $query): self
    {
        $this->conditions = $this->terms = [];
        $this->id = null;

        preg_match_all('/([\w]+:)?("([^"]*)"|([^ ]*))/', trim($query), $pieces, PREG_SET_ORDER);

        if (is_array($pieces)) {
            foreach ($pieces as $piece) {
                if (empty($piece[0])) {
                    continue;
                }

                $name = $piece[1] ? substr($piece[1], 0, -1) : null;
                $value = $piece[4] ?? $piece[3];

                //Is a condition "name:value"
                if ($name !== null) {
                    if (!isset($this->conditions[$name])) {
                        $this->conditions[$name] = [$value];
                        continue;
                    }

                    $this->conditions[$name][] = $value;
                    continue;
                }

                //Is an #id
                if (preg_match('/^#[\w-]+$/', $value)) {
                    $this->id = substr($value, 1);
                    continue;
                }

                //A generic term
                $this->terms[] = $value;
            }
        }

        return $this;
    }

    /**
     * Returns the page number.
     */
    public function getPage(): int
    {
        return $this->page ?: 1;
    }

    /**
     * Set the page.
     *
     * @return self
     */
    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Returns the limit of results per page.
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Set the limit of results per page.
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Returns the id found.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set a new id.
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns all terms in the query.
     */
    public function getTerms(): array
    {
        return $this->terms;
    }

    /**
     * Set new terms.
     */
    public function setTerms(array $terms): self
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Set new conditions.
     */
    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Return all conditions.
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * Return the sort fields. ['field' => 'direction']
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    /**
     * Set the sort and direction fields.
     */
    public function setSort(string $sort): self
    {
        $this->sort = [];

        foreach (array_filter(array_map('trim', explode(',', $sort))) as $field) {
            if ($field[0] === '-') {
                $direction = 'DESC';
                $field = substr($field, 1);
            } else {
                $direction = 'ASC';
            }

            $this->sort[$field] = $direction;
        }
    }

    /**
     * Returns the query as string.
     */
    public function buildQuery(): string
    {
        $query = implode(' ', $this->terms);

        if (!empty($this->id)) {
            $query .= " #{$this->id}";
        }

        foreach ($this->conditions as $name => $values) {
            foreach ($values as $value) {
                if (strpos($value, ' ') === false) {
                    $query .= " {$name}:{$value}";
                } else {
                    $query .= " {$name}:\"{$value}\"";
                }
            }
        }

        return trim($query);
    }

    /**
     * Returns the sort as string.
     */
    public function buildSort(): string
    {
        $sort = [];

        foreach ($this->sort as $field => $direction) {
            if ($direction === 'DESC') {
                $sort[] = '-'.$field;
            } else {
                $sort[] = $field;
            }
        }

        return implode(',', $sort);
    }
}
