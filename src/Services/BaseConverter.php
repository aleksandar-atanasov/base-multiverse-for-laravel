<?php

namespace Aleksandar\Multiverse\Services;

use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;
use Aleksandar\Multiverse\ValueObjects\BaseInput;
use Aleksandar\Multiverse\ValueObjects\BaseOutput;
use Aleksandar\Multiverse\ValueObjects\FromBase;
use Aleksandar\Multiverse\ValueObjects\ToBase;
use InvalidArgumentException;

final readonly class BaseConverter implements ConversionPolicyInterface
{

    public function convert(BaseInput $input, FromBase $fromBase, ToBase $toBase): BaseOutput
    {
        if ($fromBase->value() >= 2 && $fromBase->value() <= 36 && $toBase->value() >= 2 && $toBase->value() <= 36) {
            // Use base_convert for bases 2 to 36 and the input
            $output = base_convert(
               num: $input->value(),
               from_base: $fromBase->value(),
               to_base: $toBase->value()
            );
            return BaseOutput::fromString($output);
        }

        try {
            $output = $this->customBaseConvert(
                input: $input->value(),
                fromBase: $fromBase->value(),
                toBase: $toBase->value()
            );
            return BaseOutput::fromString($output);
        }catch (InvalidArgumentException $exception) {
            // Silently ignore the exception and return a default output
            return BaseOutput::fromString("0");
        }
    }

    private function customBaseConvert(string $input, int $fromBase, int $toBase): string
    {
        if ($fromBase === $toBase) {
            return $input;
        }
        // Silently ignore negative numbers
        $input = ltrim($input, '-');
        // Remove invalid characters from input based on the fromBase value
        $input = $this->removeInvalidCharacters($input, $fromBase);
        if ($input === "") {
            return "0";
        }
        $decimalValue = $this->baseToDecimal($input, $fromBase);
        // Convert from base 10 to the target base
        return $this->decimalToBase($decimalValue, $toBase);
    }

    private function removeInvalidCharacters(string $input, int $base): string
    {
        $validCharactersMap = config('base-multiverse.valid_chars_map');
        $validCharacters = $validCharactersMap[$base] ?? '';
        return preg_replace("/[^$validCharacters]/", '', $input);
    }

    private function baseToDecimal(string $input, int $base): float|int
    {
        $decimalValue = 0;
        $length = strlen($input);

        for ($i = 0; $i < $length; $i++) {
            $digitValue = $this->convertToDecimal($input[$i]);

            if ($digitValue < 0 || $digitValue >= $base) {
                throw new InvalidArgumentException("Invalid digit in input for base $base.");
            }

            $decimalValue = $decimalValue * $base + $digitValue;
        }

        return $decimalValue;
    }

    private function decimalToBase(int $decimalValue, int $base): string
    {
        $result = '';
        while ($decimalValue > 0) {
            $remainder = $decimalValue % $base;
            $result = $this->convertToBase($remainder) . $result;
            $decimalValue = (int)($decimalValue / $base);
        }

        return $result !== '' ? $result : '0';
    }

    private function convertToDecimal(string $character): int
    {
        $ordValue = ord($character);

        if ($ordValue >= ord('0') && $ordValue <= ord('9')) {
            return $ordValue - ord('0');
        } elseif ($ordValue >= ord('a') && $ordValue <= ord('z')) {
            return $ordValue - ord('a') + 10;
        } elseif ($ordValue >= ord('A') && $ordValue <= ord('Z')) {
            return $ordValue - ord('A') + 36;
        }

        throw new InvalidArgumentException("Unsupported character: $character");
    }

    private function convertToBase(int $decimalValue): string
    {
        if ($decimalValue >= 0 && $decimalValue <= 9) {
            return chr($decimalValue + ord('0'));
        } elseif ($decimalValue >= 10 && $decimalValue <= 35) {
            return chr($decimalValue + ord('a') - 10);
        } elseif ($decimalValue >= 36 && $decimalValue <= 61) {
            return chr($decimalValue + ord('A') - 36);
        }

        throw new InvalidArgumentException("Unsupported decimal value: $decimalValue");
    }
}
