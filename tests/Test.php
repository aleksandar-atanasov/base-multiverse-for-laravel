<?php

namespace Aleksandar\Multiverse\Tests;

use Aleksandar\Multiverse\BaseMultiverseServiceProvider;
use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;
use Aleksandar\Multiverse\CustomBaseConverter;
use Orchestra\Testbench\TestCase;

class Test extends TestCase
{
    private CustomBaseConverter $service;

    protected function setUp(): void
    {
        parent::setUp();

        (new BaseMultiverseServiceProvider(app()))->register();
        $defaultConversionPolicy = $this->app->make(ConversionPolicyInterface::class);
        $this->service = new CustomBaseConverter($defaultConversionPolicy);
    }

    /**
     * Test converting a value from base 2 to base 16.
     */
    public function testConvertFromBinaryToHex()
    {
        $input = "1101";
        $fromBase = 2;
        $toBase = 16;

        $result = $this->service->convert($input, $fromBase, $toBase);

        $this->assertEquals("d", $result);
    }

    /**
     * Test converting a value from base 16 to base 2.
     */
    public function testConvertFromHexToBinary()
    {
        $input = "d";
        $fromBase = 16;
        $toBase = 2;

        $result = $this->service->convert($input, $fromBase, $toBase);

        $this->assertEquals("1101", $result);
    }

    /**
     * Test converting a value from base 10 to base 8.
     */
    public function testConvertFromDecimalToOctal()
    {
        $input = "123";
        $fromBase = 10;
        $toBase = 8;

        $result = $this->service->convert($input, $fromBase, $toBase);

        $this->assertEquals("173", $result);
    }

    /**
     * Test converting a value from base 8 to base 10.
     */
    public function testConvertFromOctalToDecimal()
    {
        $input = "173";
        $fromBase = 8;
        $toBase = 10;

        $result = $this->service->convert($input, $fromBase, $toBase);

        $this->assertEquals("123", $result);
    }

    /**
     * Test converting a value from base 16 to base 10.
     */
    public function testConvertFromHexToDecimal()
    {
        $input = "1A";
        $fromBase = 16;
        $toBase = 10;

        $result = $this->service->convert($input, $fromBase, $toBase);

        $this->assertEquals("26", $result);
    }

    /**
     * Test converting a value with an invalid character.
     */
    public function testConvertWithInvalidCharacter()
    {
        $input = "Z"; // Invalid hex character
        $fromBase = 16;
        $toBase = 10;

        // Expect an exception
        $this->expectException(\InvalidArgumentException::class);

        $this->service->convert($input, $fromBase, $toBase);
    }
}
