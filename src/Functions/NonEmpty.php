<?php

declare(strict_types=1);

namespace Mdxqb\Functions;

use Mdxqb\Expression\Set;

class NonEmpty implements FunctionInterface
{
    /**
     * Main set
     * @var Set|FunctionInterface
     */
    protected $firstSet;

    /**
     * Second optional set
     * @var Set|FunctionInterface|null
     */
    protected ?Set $secondSet;

    /**
     * @param Set|FunctionInterface|string $firstSet
     * @param Set|FunctionInterface|string $secondSet
     */
    public function __construct($firstSet, $secondSet = null)
    {
        // Coercion to Set object
        if (!($firstSet instanceof Set) && !($firstSet instanceof FunctionInterface)) {
            $this->firstSet = new Set($firstSet);
        } else {
            $this->firstSet = $firstSet;
        }

        // Coercion to Set object if not null
        if (!($secondSet instanceof Set) && !($secondSet instanceof FunctionInterface) && !is_null($secondSet)) {
            $this->secondSet = new Set($secondSet);
        } else {
            $this->secondSet = $secondSet;
        }
    }

    /**
     * Returns MDX query part
     * @return string
     */
    public function getMdx(): string
    {
        return 'NONEMPTY(' .
            $this->firstSet->getMdx() .
            (!is_null($this->secondSet)
                ? ', ' . $this->secondSet->getMdx()
                : ''
            ) .
            ')';
    }
}