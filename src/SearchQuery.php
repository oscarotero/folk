<?php

namespace Folk;

/**
 * Class to manage a query to search rows.
 */
class SearchQuery
{
    protected $page;
    protected $ids = [];
    protected $conditions = [];
    protected $words = [];

    /**
     * @param array $query
     */
    public function __construct(array $query = [])
    {
        if (!empty($query['query'])) {
            $this->parseQuery($query['query']);
        }

        $this->page = isset($query['page']) ? $query['page'] : null;
    }

    /**
     * Returns the query as string.
     *
     * @return string
     */
    public function getQuery()
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
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * Returns the first id.
     *
     * @return string|null
     */
    public function getId()
    {
        return isset($this->ids[0]) ? $this->ids[0] : null;
    }

    /**
     * Returns all ids found.
     *
     * @return array
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * Set new ids.
     *
     * @param array $ids
     */
    public function setIds(array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * Returns all words in the query.
     *
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Set new words.
     *
     * @param array $words
     */
    public function setWords(array $words)
    {
        $this->words = $words;
    }

    /**
     * Return a condition.
     *
     * @return array|null
     */
    public function getCondition($name)
    {
        return isset($this->conditions[$name]) ? $this->conditions[$name] : null;
    }

    /**
     * Set a new condition.
     *
     * @param string $name
     * @param array  $value
     */
    public function setCondition($name, array $value)
    {
        return $this->conditions[$name] = $value;
    }

    /**
     * Return a condition.
     *
     * @return array
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Split a query in pieces.
     *
     * @param string $query
     *
     * @return array
     */
    protected function parseQuery($query)
    {
        preg_match_all('/([\w]+:)?("([^"]*)"|([^ ]*))/', trim($query), $pieces, PREG_SET_ORDER);

        if (is_array($pieces)) {
            foreach ($pieces as $piece) {
                if (empty($piece[0])) {
                    continue;
                }

                $name = $piece[1] ? substr($piece[1], 0, -1) : null;
                $value = isset($piece[4]) ? $piece[4] : $piece[3];

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
    }
}
