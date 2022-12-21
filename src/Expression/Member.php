<?php

declare(strict_types=1);

namespace Mdxqb\Expression;

class Member implements ExpressionInterface
{
    protected string $mdx;

    /**
     * Create Member object from string
     * @param string $mdx
     */
    public function __construct(string $mdx)
    {
        /**
         * TODO parse string, validate syntax, split hierarchy, and so on if needed, but not now
         */

        $this->mdx = $mdx;
    }

    /**
     * Resolve input expression into Member object
     * @param $expression
     * @return Member|null
     * @throws InvalidMemberDeclarationException
     */
    public static function resolve($expression): ?Member
    {
        if ($expression instanceof Member) {
            return $expression;
        }

        if (is_string($expression)) {
            return new Member($expression);
        }

        if (is_null($expression)) {
            return null;
        }

        throw new InvalidMemberDeclarationException();
    }

    /**
     * Returns MDX query part
     * @return string
     */
    public function getMdx(): string
    {
        return $this->mdx;
    }
}