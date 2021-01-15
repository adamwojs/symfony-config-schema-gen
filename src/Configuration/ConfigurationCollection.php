<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration;

use ArrayIterator;
use Iterator;
use IteratorAggregate;

final class ConfigurationCollection implements IteratorAggregate
{
    /** @var \Symfony\Component\Config\Definition\ConfigurationInterface[] */
    private $configurations;

    /**
     * @param \Symfony\Component\Config\Definition\ConfigurationInterface[] $configurations
     */
    public function __construct(array $configurations)
    {
        $this->configurations = $configurations;

        ksort($this->configurations, SORT_STRING);
    }

    public function isEmpty(): bool
    {
        return empty($this->configurations);
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->configurations);
    }
}
