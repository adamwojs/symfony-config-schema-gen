<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher;

final class ExtensionMatcherFactory
{
    /**
     * Create an extension matcher based on the given extension name.
     *
     * If the extension name contains a wildcard character (*), a WildcardExtensionMatcher is created.
     * Otherwise, an ExplicitExtensionMatcher is created.
     */
    public function createMatcher(string $extension): ExtensionMatcherInterface
    {
        if ($this->isWildcard($extension)) {
            return new WildcardExtensionMatcher($extension);
        }

        return new ExplicitExtensionMatcher($extension);
    }

    public function createCompositeMatcher(array $extensions): ExtensionMatcherInterface
    {
        $matchers = array_map(
            fn (string $extension) => $this->createMatcher($extension),
            $extensions
        );

        return new CompositeExtensionMatcher($matchers);
    }

    /**
     * Check if the given extension name contains a wildcard character.
     */
    private function isWildcard(string $extension): bool
    {
        return str_contains($extension, '*');
    }
}
