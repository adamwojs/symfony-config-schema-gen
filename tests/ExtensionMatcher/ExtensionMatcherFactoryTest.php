<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Tests\ExtensionMatcher;

use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\ExtensionMatcherFactory;
use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\ExplicitExtensionMatcher;
use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\WildcardExtensionMatcher;
use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\CompositeExtensionMatcher;
use AdamWojs\SymfonyConfigGenBundle\ExtensionMatcher\ExtensionMatcherInterface;
use PHPUnit\Framework\TestCase;

final class ExtensionMatcherFactoryTest extends TestCase
{
    public function testCreateMatcherReturnsExplicitExtensionMatcher(): void
    {
        $matcher = (new ExtensionMatcherFactory())->createMatcher('foo');

        $this->assertInstanceOf(ExplicitExtensionMatcher::class, $matcher);
    }

    public function testCreateMatcherReturnsWildcardExtensionMatcher(): void
    {
        $matcher = (new ExtensionMatcherFactory())->createMatcher('bar*');

        $this->assertInstanceOf(WildcardExtensionMatcher::class, $matcher);
    }

    public function testCreateCompositeMatcherReturnsCompositeExtensionMatcher(): void
    {
        $matcher = (new ExtensionMatcherFactory())->createCompositeMatcher(['foo', 'bar*']);

        $this->assertInstanceOf(CompositeExtensionMatcher::class, $matcher);

    }
}
