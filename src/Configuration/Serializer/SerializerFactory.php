<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

final class SerializerFactory
{
    public function __construct(
        /** @var iterable<\Symfony\Component\Serializer\Normalizer\NormalizerInterface> */
        private iterable $normalizers
    ) {
    }

    public function createSerializer(): Serializer
    {
        $encoders = [
            new JsonEncoder(),
        ];

        return new Serializer(iterator_to_array($this->normalizers), $encoders);
    }
}
