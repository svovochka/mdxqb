<?php

declare(strict_types=1);

namespace Mdxqb;

/**
 * MDX query builder class
 */
class Query
{
    /**
     * Named Axis index 1
     */
    const AXIS_COLUMNS = 'COLUMNS';

    /**
     * Named Axis index 2
     */
    const AXIS_ROWS = 'ROWS';

    /**
     * Named Axis index 3
     */
    const AXIS_PAGES = 'PAGES';

    /**
     * Named Axis index 4
     */
    const AXIS_SECTIONS = 'SECTIONS';

    /**
     * Named Axis index 5
     */
    const AXIS_CHAPTERS = 'CHAPTERS';

    /**
     * With clauses
     * @var WithClause[]|string[]
     */
    protected array $with = [];

    /**
     * Select clauses by axis [axis][clause]
     * @var array
     */
    protected array $select = [];

    /**
     * From expression
     * @var string|Query
     */
    protected $from;

    /**
     * Add multiple WITH clauses
     * @param WithClause|string ...$withClauses
     * @return $this
     */
    public function with(...$withClauses): Query
    {
        foreach ($withClauses as $withClause) {
            $this->addWith($withClause);
        }
        return $this;
    }

    /**
     * @param WithClause|string $withClause
     * @return $this
     */
    public function addWith($withClause): Query
    {
        $this->with[] = $withClause;

        return $this;
    }

    /**
     * Add select expression to specified named or numbered axis
     * @param $selectExpression
     * @param string|int $axis
     * @return void
     */
    public function addSelectOn($selectExpression, $axis): void
    {
        // Resolve index to named axis
        switch($axis){
            case 1:
                $axis = self::AXIS_COLUMNS;
                break;
            case 2:
                $axis = self::AXIS_ROWS;
                break;
            case 3:
                $axis = self::AXIS_PAGES;
                break;
            case 4:
                $axis = self::AXIS_SECTIONS;
                break;
            case 5:
                $axis = self::AXIS_CHAPTERS;
                break;
        }

        if (!array_key_exists($axis, $this->select)) {
            $this->select[$axis] = [];
        }
        $this->select[$axis][] = $selectExpression;
    }

    /**
     * Add multiple select expressions to COLUMNS axis
     * @param ...$selectExpressions
     * @return $this
     */
    public function selectOnColumns(...$selectExpressions): Query
    {
        foreach ($selectExpressions as $selectExpression) {
            $this->addSelectOnColumns($selectExpression);
        }

        return $this;
    }

    /**
     * Add select expression to COLUMNS axis
     * @param $selectExpression
     * @return $this
     */
    public function addSelectOnColumns($selectExpression): Query
    {
        $this->addSelectOn($selectExpression, self::AXIS_COLUMNS);

        return $this;
    }

    /**
     * Add multiple select expressions to ROWS axis
     * @param ...$selectExpressions
     * @return $this
     */
    public function selectOnRows(...$selectExpressions): Query
    {
        foreach ($selectExpressions as $selectExpression) {
            $this->addSelectOnRows($selectExpression);
        }

        return $this;
    }

    /**
     * Add select expression to ROWS axis
     * @param $selectExpression
     * @return $this
     */
    public function addSelectOnRows($selectExpression): Query
    {
        $this->addSelectOn($selectExpression, self::AXIS_ROWS);

        return $this;
    }

    /**
     * Set FROM, cube name or sub query
     * @param string|Query $from
     * @return $this
     */
    public function from($from): Query
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Returns MDX query
     * @return string
     */
    public function getMdx(): string
    {
        $query = '';

        // Render WITH
        if (!empty($this->with)) {
            $query .= 'WITH ';
            $withClauses = [];
            foreach ($this->with as $withClause) {
                $withClauses[] = is_string($withClause)
                    ? $withClause
                    : $withClause->getMdx();

            }
            $query .= implode(', ', $withClauses);
        }

        // Render SELECT part
        $axisClauses = [];
        foreach ($this->select as $axis => $selectExpressions) {
            foreach ($selectExpressions as $selectExpression) {
                $propertyClauses = [];
                if (is_string($selectExpression)) {
                    $propertyClauses[] = $selectExpression;
                } else {
                    $propertyClauses[] = $selectExpression->getMdx();
                }
                $axisClauses[] = implode(', ', $propertyClauses) . ' ON ' . $axis;
            }
        }
        $query .= ' SELECT ' . implode(', ', $axisClauses);

        // Render FROM part
        $query .= ' FROM ';
        if (is_string($this->from)) {
            $query .= $this->from;
        } else {
            $query .= '(' . $this->from->getMdx() . ')';
        }

        //todo WHERE clauses

        return $query;
    }
}