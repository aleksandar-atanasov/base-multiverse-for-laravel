<?php

namespace Aleksandar\Multiverse\Tests;

use Aleksandar\Multiverse\BaseMultiverseServiceProvider;
use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;
use Aleksandar\Multiverse\CustomBaseConverter;
use Orchestra\Testbench\TestCase;

class Test extends TestCase
{
    private CustomBaseConverter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        (new BaseMultiverseServiceProvider(app()))->register();
        $defaultConversionPolicy = $this->app->make(ConversionPolicyInterface::class);
        $this->converter = new CustomBaseConverter($defaultConversionPolicy);
    }

    public function test_convert_positive_integer_from_base_10_to_base_62(): void
    {
        $result = $this->converter->convert(
            input: '100000000000',
            fromBase: 10,
            toBase: 62
        );

        $this->assertEquals('1L9zO9O', $result);
    }

    public function test_convert_string_from_base_62_to_base_10(): void
    {
        $result = $this->converter->convert(
            input: '1L9zO9O',
            fromBase: 62,
            toBase: 10
        );

        $this->assertEquals('100000000000', $result);
    }

    public function test_convert_zero_from_base_10_to_base_62(): void
    {
        $result = $this->converter->convert(
            input: '0',
            fromBase: 10,
            toBase: 62
        );

        $this->assertEquals('0', $result);
    }

    public function test_convert_zero_from_base_62_to_base_10(): void
    {
        $result = $this->converter->convert(
            input: '0',
            fromBase: 62,
            toBase: 10
        );

        $this->assertEquals('0', $result);
    }

    public function test_it_ignores_negative_input_values_from_base_10_to_base_62(): void
    {
        $result = $this->converter->convert(
            input: '-100000000000',
            fromBase: 10,
            toBase: 62
        );

        $this->assertEquals('1L9zO9O', $result);
    }

    public function test_it_ignores_invalid_input_chars_from_base_8_to_base_10(): void
    {
        $result = $this->converter->convert(
            input: '0977567',
            fromBase: 8,
            toBase: 10
        );

        $this->assertEquals('32631', $result);
    }
}
