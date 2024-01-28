<?php

namespace Aleksandar\Multiverse\Validation;

use Aleksandar\Multiverse\Contracts\ValidatorInterface;

final class InputValidator implements ValidatorInterface
{
    public function isValidCharset(int|string $input, int $fromBase): bool
    {
        $characterSetRanges = config('base-multiverse.character_set_ranges');
        foreach ($characterSetRanges as [$start, $end, $pattern]) {
            if ($fromBase >= $start && $fromBase <= $end) {
                return preg_match($pattern, $input) > 0;
            }
        }

        return false;
    }

    public function isValidBase(int $base): bool
    {
        return $base >= 2 && $base <= 62;
    }
}
