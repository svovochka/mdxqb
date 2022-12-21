<?php

declare(strict_types=1);

namespace Mdxqb\Functions;

use Mdxqb\Expression\Set;

class CrossJoin implements FunctionInterface
{
    /**
     * @var Set[]|FunctionInterface[]
     */
    protected array $sets = [];

    /**
     * Add sets or function expressions to be joined
     * @param Set|FunctionInterface|string ...$sets
     */
    public function __construct(...$sets)
    {
        foreach ($sets as $set) {
            $this->addSet($set);
        }
    }

    /**
     * Add set or function expression to be joined
     * @param Set|FunctionInterface|string $set
     * @return $this
     */
    public function addSet($set): CrossJoin
    {
        if (!($set instanceof Set) && !($set instanceof FunctionInterface)) {
            $set = new Set($set);
        }

        $this->sets[] = $set;

        return $this;
    }

    /**
     * Returns MDX query part
     * @return string
     */
    public function getMdx(): string
    {
        $setsExpressions = [];
        foreach ($this->sets as $set) {
            $setsExpressions[] = $set->getMdx();
        }
        return implode(' * ', $setsExpressions);
    }
}