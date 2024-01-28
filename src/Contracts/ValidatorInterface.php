<?php

namespace Aleksandar\Multiverse\Contracts;

interface ValidatorInterface
{
    public function isValidCharset(int|string $input, int $fromBase): bool;

    public function isValidBase(int $base): bool;
}
