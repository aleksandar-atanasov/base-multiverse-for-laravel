<?php

namespace Aleksandar\Multiverse\ValueObjects;

final readonly class ToBase
{
    private function __construct(private int $value)
    {
        if ($value < 2 || $value > 62) {
            throw new \InvalidArgumentException("Invalid base provided. To base must be integer between 2 and 62.");
        }
    }

    public static function fromInt(int $value): ToBase
    {
        return new ToBase($value);
    }

    public function value(): int
    {
        return $this->value;
    }
}
