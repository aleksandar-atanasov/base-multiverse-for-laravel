<?php

namespace Aleksandar\Multiverse\ValueObjects;

final readonly class BaseOutput
{
    private function __construct(private string $value)
    {

    }

    public static function fromString(string $value): BaseOutput
    {
        return new BaseOutput($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
