<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher;

/**
 * Matches extension aliases using wildcard patterns (e.g. "acme_*").
 */
final class WildcardExtensionMatcher implements ExtensionMatcherInterface
{
    private string $regex;

    public function __construct(string $wildcard)
    {
        $this->regex = $this->createRegex($wildcard);
    }

    public function matches(string $alias): bool
    {
        return preg_match($this->regex, $alias) === 1;
    }

    /**
     * Convert a wildcard pattern to a regular expression.
     *
     * The wildcard character (*) is replaced with a regex pattern that matches any sequence of characters.
     */
    private function createRegex(string $wildcard): string
    {
        return '/^' . str_replace('\*', '.*', preg_quote($wildcard, '/')) . '$/';
    }
}
