<?php

namespace Folk;

/**
 * Class to manage a query to search rows.
 */
class SearchQuery
{
    protected $limit = 50;
    protected $page;
    protected $ids = [];
    protected $conditions = [];
    protected $words = [];
    protected $sort = [];

    /**
     * @param array $query
     */
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
     *
     * @param string $query
     *
     * @return self
     */
    public function setQuery($query)
    {
        $this->conditions = $this->ids = $this->words = [];

        preg_match_all('/([\w]+:)?("([^"]*)"|([^ ]*))/', trim($query), $pieces, PREG_SET_ORDER);

        if (is_array($pieces)) {
            foreach ($pieces as $piece) {
                if (empty($piece[0])) {
                    continue;
                }

                $name = $piece[1] ? substr($piece[1], 0, -1) : null;
                $value = $piece[4] ?? $piece[3];

                if ($name !== null) {
                    if (!isset($this->conditions[$name])) {
                        $this->conditions[$name] = [$value];
                    } else {
                        $this->conditions[$name][] = $value;
                    }
                } elseif (preg_match('/^#[\w-]+$/', $value)) {
                    $this->ids[] = substr($value, 1);
                } else {
                    $this->words[] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * Returns the page number.
     *
     * @return null|int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set the page.
     *
     * @param null|int $page
     *
     * @return self
     */
    public function setPage($page): self
    {
        $this->page = (int) $page;

        return $this;
    }

    /**
     * Returns the limit of results per page.
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Set the limit of results per page.
     *
     * @param int $limit
     *
     * @return self
     */
    public function setLimit(int $limit): self
    {
        $this->limit = (int) $limit;

        return $this;
    }

    /**
     * Returns all ids found.
     *
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * Set new ids.
     *
     * @param array $ids
     *
     * @return self
     */
    public function setIds(array $ids): self
    {
        $this->ids = $ids;

        return $this;
    }

    /**
     * Returns all words in the query.
     *
     * @return array
     */
    public function getWords(): array
    {
        return $this->words;
    }

    /**
     * Set new words.
     *
     * @param array $words
     *
     * @return self
     */
    public function setWords(array $words): self
    {
        $this->words = $words;

        return $this;
    }

    /**
     * Set new conditions.
     *
     * @param array $conditions
     *
     * @return self
     */
    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Return all conditions.
     *
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * Return the sort fields.
     *
     * @return array ['field' => 'direction']
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    /**
     * Set the sort and direction fields.
     *
     * @param string $sort
     */
    public function setSort(string $sort)
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
     *
     * @return string
     */
    public function buildQuery(): string
    {
        $query = implode(' ', $this->words);

        foreach ($this->ids as $id) {
            $query .= " #{$id}";
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
     *
     * @return string
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
