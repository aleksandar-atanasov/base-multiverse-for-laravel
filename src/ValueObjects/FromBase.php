<?php

namespace Aleksandar\Multiverse\ValueObjects;

final readonly class FromBase
{
    private function __construct(private int $value)
    {
        if ($value < 2 || $value > 62) {
            throw new \InvalidArgumentException("Invalid base provided. From base must be integer between 2 and 62.");
        }
    }

    public static function fromInt(int $value): FromBase
    {
        return new FromBase($value);
    }

    public function value(): int
    {
        return $this->value;
    }
}
