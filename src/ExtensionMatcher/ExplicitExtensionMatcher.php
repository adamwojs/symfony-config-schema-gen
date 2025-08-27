<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher;

/**
 * Matches a specific, explicit extension alias.
 */
final readonly class ExplicitExtensionMatcher implements ExtensionMatcherInterface
{
    public function __construct(
        private string $alias
    ) {
    }

    public function matches(string $alias): bool
    {
        return $this->alias === $alias;
    }
}
