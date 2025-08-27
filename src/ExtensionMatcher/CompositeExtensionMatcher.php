<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher;

/**
 * Matches if any of the composed matchers matches.
 *
 * If no matchers are provided, it matches everything.
 */
final readonly class CompositeExtensionMatcher implements ExtensionMatcherInterface
{
    public function __construct(
        private array $matchers
    ) {
    }

    public function matches(string $alias): bool
    {
        if ($this->matchers === []) {
            return true;
        }

        foreach ($this->matchers as $matcher) {
            if ($matcher->matches($alias)) {
                return true;
            }
        }

        return false;
    }
}
