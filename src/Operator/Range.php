<?php

declare(strict_types=1);

namespace Mdxqb\Operator;

use Mdxqb\Expression\Member;

class Range implements OperatorInterface
{

    /**
     * Range begin (from first element if NULL)
     * @var Member|null
     */
    protected ?Member $from = null;

    /**
     * Range end (to last element if NULL)
     * @var Member|null
     */
    protected ?Member $to = null;

    /**
     * @param Member|string|null $from
     * @param Member|string|null $to
     */
    public function __construct($from, $to)
    {
        $this->from = Member::resolve($from);
        $this->to = Member::resolve($to);
    }

    /**
     * Returns MDX query part
     * @return string
     */
    public function getMdx(): string
    {
        return '{' .
            (is_null($this->from) ? 'NULL' : $this->from->getMdx()) .
            ' : ' .
            (is_null($this->to) ? 'NULL' : $this->to->getMdx()) .
            '}';
    }
}