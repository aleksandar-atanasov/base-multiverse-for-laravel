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
            input: 12345,
            fromBase: 10,
            toBase: 62
        );

        $this->assertEquals('3d7', strtolower($result));
    }

    public function test_convert_zero_from_base_10_to_base_62(): void
    {
        $result = $this->converter->convert(
            input: 0,
            fromBase: 10,
            toBase: 62
        );

        $this->assertEquals('0', $result);
    }
}
