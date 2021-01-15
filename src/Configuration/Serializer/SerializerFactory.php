<?php

declare(strict_types=1);

namespace AdamWojs\SymfonyConfigGenBundle\Configuration\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

final class SerializerFactory
{
    /** @var \Symfony\Component\Serializer\Normalizer\NormalizerInterface */
    private $normalizers;

    public function __construct(iterable $normalizers)
    {
        $this->normalizers = [];
        foreach ($normalizers as $normalizer) {
            $this->normalizers[] = $normalizer;
        }
    }

    public function createSerializer(): Serializer
    {
        $encoders = [
            new JsonEncoder(),
        ];

        return new Serializer($this->normalizers, $encoders);
    }
}
