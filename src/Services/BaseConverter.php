<?php

namespace Aleksandar\Multiverse\Services;

use Aleksandar\Multiverse\Contracts\ValidatorInterface;
use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;
use Aleksandar\Multiverse\Exception\InvalidCharacterException;
use InvalidArgumentException;

final class BaseConverter implements ConversionPolicyInterface
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function convert(int|string $input, int $fromBase, int $toBase): string
    {
        if (!$this->validator->isValidBase($fromBase) || !$this->validator->isValidBase($toBase)) {
            throw new InvalidArgumentException("Invalid base provided. Bases must be integers between 2 and 62.");
        }

        // this is loosely checked
        if (!$this->validator->isValidCharset($input, $fromBase)) {
            throw new InvalidCharacterException("Invalid character in input: $input for base: $fromBase");
        }

        if ($fromBase >= 2 && $fromBase <= 36 && $toBase >= 2 && $toBase <= 36) {
            // Use base_convert for bases 2 to 36
            return base_convert($input, $fromBase, $toBase);
        } else {
            return $this->customBaseConvert($input, $fromBase, $toBase);
        }
    }

    private function customBaseConvert(int|string $input, int $fromBase, int $toBase): string
    {
        if ($fromBase === $toBase) {
            return $input;
        }
        // Convert to base 10
        $decimalValue = $this->baseToDecimal($input, $fromBase);
        // Convert from base 10 to the target base
        return $this->decimalToBase($decimalValue, $toBase);
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

    private function decimalToBase(float|int $decimalValue, int $base): string
    {
        if (!$this->validator->isValidBase($base)) {
            throw new InvalidArgumentException("Unsupported target base. Base must be between 2 and 62.");
        }

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
