<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Tests\ExtensionMatcher;

use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\WildcardExtensionMatcher;
use PHPUnit\Framework\TestCase;

final class WildcardExtensionMatcherTest extends TestCase
{
    public function testMatchesWithWildcardAtEnd(): void
    {
        $matcher = new WildcardExtensionMatcher('acme_*');

        $this->assertTrue($matcher->matches('acme_demo'));
        $this->assertTrue($matcher->matches('acme_'));
        $this->assertFalse($matcher->matches('acme'));
        $this->assertFalse($matcher->matches('foo_acme_demo'));
    }

    public function testMatchesWithWildcardAtStart(): void
    {
        $matcher = new WildcardExtensionMatcher('*_demo');

        $this->assertTrue($matcher->matches('acme_demo'));
        $this->assertTrue($matcher->matches('_demo'));
        $this->assertFalse($matcher->matches('acmedemo'));
        $this->assertFalse($matcher->matches('demo_acme'));
    }

    public function testMatchesWithWildcardInMiddle(): void
    {
        $matcher = new WildcardExtensionMatcher('acme*_demo');

        $this->assertTrue($matcher->matches('acme_demo'));
        $this->assertTrue($matcher->matches('acme123_demo'));
        $this->assertFalse($matcher->matches('acme'));
        $this->assertFalse($matcher->matches('demo_acme'));
    }

    public function testMatchesWithNoWildcard(): void
    {
        $matcher = new WildcardExtensionMatcher('acme_demo');

        $this->assertTrue($matcher->matches('acme_demo'));
        $this->assertFalse($matcher->matches('acme_demo2'));
        $this->assertFalse($matcher->matches('demo_acme'));
    }
}
