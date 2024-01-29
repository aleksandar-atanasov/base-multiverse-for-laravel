<?php

namespace Aleksandar\Multiverse\Contracts;

use Aleksandar\Multiverse\ValueObjects\BaseInput;
use Aleksandar\Multiverse\ValueObjects\BaseOutput;
use Aleksandar\Multiverse\ValueObjects\FromBase;
use Aleksandar\Multiverse\ValueObjects\ToBase;

interface ConversionPolicyInterface
{
    public function convert(BaseInput $input, FromBase $fromBase, ToBase $toBase): BaseOutput;
}
