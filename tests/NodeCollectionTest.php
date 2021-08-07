<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use PhpDs\Node;
use PhpDs\NodeCollection;

class NodeCollectionTest extends TestCase
{
    public function addDataProvider()
    {
        $floats = range(1e-4, 10e-3, 10e-4);
        return array_map(
            fn ($v) => [new class ($v) extends Node {
                public function getValue(): string|int|float|bool|null|object {
                    return $this->value;
                }
            }],
            [
                random_int(PHP_INT_MIN, PHP_INT_MAX),
                base64_encode(random_bytes(8)),
                fn () => null,
                null,
                $floats[array_rand($floats)],
                (object)""
            ]
        );
    }

    public function countDataProvider()
    {
        $countValues = range(0, 10);
        $floats = range(1e-4, 10e-3, 10e-4);
        return array_map(
            fn ($v) => [new class ($v) extends Node {
                public function getValue(): string|int|float|bool|null|object {
                    return $this->value;
                }
            }, $countValues[array_rand($countValues)]],
            [
                random_int(PHP_INT_MIN, PHP_INT_MAX),
                base64_encode(random_bytes(8)),
                fn () => null,
                null,
                $floats[array_rand($floats)],
                (object)""
            ]
        );
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testTheAddMethodAddsAValue(Node $value)
    {
        $sut = new class() extends NodeCollection {};

        $sut->add($value);

        $sut->map(fn ($actual) => $this->assertEquals($value->getValue(), $actual->getValue()));
    }

    /**
     * @dataProvider countDataProvider
     */
    public function testTheCountMethodReturnsTheExpectedNumberForNonRecursiveCollections(Node $value, int $count)
    {
        $sut = new class extends NodeCollection {};

        $valueRepeated = array_fill(0, $count, $value);

        array_walk($valueRepeated, [$sut, "add"]);

        $this->assertEquals($count, $sut->count());
    }

    public function testDoesNotCallGivenFunctionWhenCollectionIsEmpty()
    {
        $sut = new class extends NodeCollection {};

        $sut->map(fn () => $this->fail("Should not have been called because this collection is empty."));

        $this->assertTrue(true);
    }

    public function testCountIsZeroWhenCollectionIsEmpty()
    {
        $sut = new class extends NodeCollection {};

        $this->assertTrue($sut->count() === 0);
    }
}
