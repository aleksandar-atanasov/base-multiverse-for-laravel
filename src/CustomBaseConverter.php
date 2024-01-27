<?php

namespace Aleksandar\Multiverse;

use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;

final class CustomBaseConverter
{
    public function __construct(private readonly ConversionPolicyInterface $converter)
    {
    }

    public function convert(int|string $input, int $fromBase, int $toBase): string
    {
        return $this->converter->convert(
            input: $input,
            fromBase: $fromBase,
            toBase: $toBase
        );
    }
}
