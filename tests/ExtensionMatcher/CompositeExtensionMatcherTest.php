<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Tests\ExtensionMatcher;

use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\CompositeExtensionMatcher;
use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\ExplicitExtensionMatcher;
use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\WildcardExtensionMatcher;
use PHPUnit\Framework\TestCase;

final class CompositeExtensionMatcherTest extends TestCase
{
    public function testMatchesReturnsTrueIfAnyMatcherMatches(): void
    {
        $matcher = new CompositeExtensionMatcher([
            new ExplicitExtensionMatcher('foo'),
            new WildcardExtensionMatcher('bar*'),
        ]);

        $this->assertTrue($matcher->matches('foo'));
        $this->assertTrue($matcher->matches('bar123'));
    }

    public function testMatchesReturnsFalseIfNoMatcherMatches(): void
    {
        $matcher = new CompositeExtensionMatcher([
            new ExplicitExtensionMatcher('foo'),
            new WildcardExtensionMatcher('bar*'),
        ]);

        $this->assertFalse($matcher->matches('baz'));
        $this->assertFalse($matcher->matches('qux'));
    }

    public function testMatchesWithEmptyMatchersArray(): void
    {
        $matcher = new CompositeExtensionMatcher([]);

        $this->assertTrue($matcher->matches('any_alias'));
    }
}
