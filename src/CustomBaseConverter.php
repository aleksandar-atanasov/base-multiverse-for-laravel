<?php

namespace Aleksandar\Multiverse;

use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;
use Aleksandar\Multiverse\ValueObjects\BaseInput;
use Aleksandar\Multiverse\ValueObjects\FromBase;
use Aleksandar\Multiverse\ValueObjects\ToBase;

final readonly class CustomBaseConverter
{
    public function __construct(private ConversionPolicyInterface $converter)
    {
    }

    public function convert(string $input, int $fromBase, int $toBase): string
    {
        return $this->converter->convert(
            input: BaseInput::fromString($input),
            fromBase: FromBase::fromInt($fromBase),
            toBase: ToBase::fromInt($toBase)
        )->value();
    }
}
