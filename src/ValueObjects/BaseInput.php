<?php

namespace Aleksandar\Multiverse\ValueObjects;

final readonly class BaseInput
{

    private function __construct(private string $value)
    {

    }

    public static function fromString(string $value): BaseInput
    {
        return new BaseInput($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
