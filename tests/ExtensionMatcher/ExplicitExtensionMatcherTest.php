<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Tests\ExtensionMatcher;

use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\ExplicitExtensionMatcher;
use PHPUnit\Framework\TestCase;

final class ExplicitExtensionMatcherTest extends TestCase
{
    public function testMatchesReturnsTrueForMatchingAlias(): void
    {
        $matcher = new ExplicitExtensionMatcher('example_extension');

        $this->assertTrue($matcher->matches('example_extension'));
    }

    public function testMatchesReturnsFalseForNonMatchingAlias(): void
    {
        $matcher = new ExplicitExtensionMatcher('example_extension');

        $this->assertFalse($matcher->matches('other_alias'));
    }
}
