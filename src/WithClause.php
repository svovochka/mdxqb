<?php

declare(strict_types=1);

namespace Mdxqb;

class WithClause
{
    protected string $clause;

    public function __construct($clause)
    {
        $this->clause = $clause;
    }

    /**
     * Returns MDX query part
     * @return string
     */
    public function getMdx(): string
    {
        return $this->clause;
    }
}