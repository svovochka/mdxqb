<?php

declare(strict_types=1);

namespace Mdxqb\Expression;

class Tuple implements ExpressionInterface
{

    /**
     * @var Member[]
     */
    protected array $members = [];

    /**
     * @param Member|string ...$members
     */
    public function __construct(...$members)
    {
        foreach ($members as $member) {
            $this->addMember($member);
        }
    }

    /**
     * @param Member|string $member
     * @return $this
     */
    public function addMember($member): Tuple
    {
        $this->members[] = Member::resolve($member);

        return $this;
    }

    /**
     * Returns MDX query part
     * @return string
     */
    public function getMdx(): string
    {
        if (count($this->members) === 1) {
            return $this->members[0]->getMdx();
        }

        // Render members into array of strings
        $memberExpressions = [];
        foreach ($this->members as $member) {
            $memberExpressions[] = $member->getMdx();
        }

        return '(' . implode(', ', $memberExpressions) . ')';
    }
}