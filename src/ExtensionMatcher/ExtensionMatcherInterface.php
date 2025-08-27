<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher;

interface ExtensionMatcherInterface
{
    public function matches(string $alias): bool;
}
