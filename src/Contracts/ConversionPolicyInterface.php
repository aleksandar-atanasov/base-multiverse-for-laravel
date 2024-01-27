<?php

namespace Aleksandar\Multiverse\Contracts;

interface ConversionPolicyInterface
{
    public function convert(int|string $input, int $fromBase, int $toBase): string;
}
