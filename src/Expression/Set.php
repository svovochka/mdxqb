<?php

declare(strict_types=1);

namespace Mdxqb\Expression;

class Set implements ExpressionInterface
{
    /**
     * @var Tuple[]
     */
    protected array $tuples = [];

    /**
     * @param Tuple|Member|string ...$tuples
     */
    public function __construct(...$tuples)
    {
        foreach ($tuples as $tuple) {
            $this->addTuple($tuple);
        }
    }

    /**
     * @param Tuple|Member|string $tuple
     * @return $this
     */
    public function addTuple($tuple): Set
    {
        // Coercion to Tuple object
        if (!($tuple instanceof Tuple)) {
            $tuple = new Tuple($tuple);
        }

        $this->tuples[] = $tuple;

        return $this;
    }

    /**
     * Returns MDX query part
     * @return string
     */
    public function getMdx(): string
    {
        // Don't cover single tuple in set with braces
        if (count($this->tuples) === 1) {
            return $this->tuples[0]->getMdx();
        }

        // Render tuples into array of strings
        $tupleExpressions = [];
        foreach ($this->tuples as $tuple) {
            $tupleExpressions[] = $tuple->getMdx();
        }

        // Build set expression
        return '{' . implode(', ', $tupleExpressions) . '}';
    }
}