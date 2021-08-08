<?php

use PhpDs\Set;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    public function valueProvider()
    {
        return [
            [ array_merge(range(1,100), range(10e2, 10e3, 10e2), array_fill(0, 5, (object)""), [true, false]) ]
        ];
    }

    public function testShouldBeAbleToAddDistinctFalsyValues()
    {
        $falsyValues = ["", false, 0, 0.0, null];
        
        $sut = new Set();

        array_walk($falsyValues, [$sut, "add"]);

        $this->assertCount(count($falsyValues), $sut);
    }

    public function testShouldBeAbleToAddStringIntegersAndLiteralIntegers()
    {
        $integers = range(1, 300);
        $stringIntegers = array_map("strval", $integers);
        $bothKinds = array_merge($integers, $stringIntegers);

        $sut = new Set();

        array_walk($bothKinds, [$sut, "add"]);

        $this->assertCount(count($integers) + count($stringIntegers), $sut);
    }

    public function testShouldBeAbleToAddStringFloatsAndLiteralFloats()
    {
        $floats = range(10e-3, 10e-2, 10e-3);
        $stringFloats = array_map("strval", $floats);
        $bothKinds = array_merge($floats, $stringFloats);

        $sut = new Set();

        array_walk($bothKinds, [$sut, "add"]);

        $this->assertCount(count($floats) + count($stringFloats), $sut);
    }

    public function testShouldBeAbleToAddDistinctObjects()
    {
        $a = (object)"";
        $b = (object)"";
        $c = (object)"";
        $objects = [$a, $b, $c];

        $sut = new Set();

        array_walk($objects, [$sut, "add"]);

        $this->assertCount(count($objects), $sut);
    }

    public function testShouldNotAddTheSameObjectMoreThanOnce()
    {
        $object = (object)"";
        $ref = $object;

        $sut = new Set();

        $sut->add($object);
        $sut->add($ref);

        $this->assertCount(1, $sut);
    }

    public function testShouldBeAbleToGetTheMaxNumericValue()
    {
        $max = random_int(42, 98);
        $values = range(1, $max);

        $sut = new Set();

        array_walk($values, [$sut, "add"]);

        $this->assertEquals($max, $sut->max());
    }

    public function testShouldBeAbleToGetCardinality()
    {
        $sut = new Set();

        $arr = range(10, 220);

        array_walk($arr, [$sut, "add"]);

        $this->assertEquals(count($arr), $sut->cardinality());
    }

    public function testShouldOnlyContainDistinctValues()
    {
        $sut = new Set();

        $arr = range(1, 10);
        $duplicates = $arr;

        $arrayWithDuplicates = array_merge($arr, $duplicates);

        array_walk($arrayWithDuplicates, [$sut, "add"]);

        $this->assertNotEquals(count($sut), count($arrayWithDuplicates));
    }

    /**
     * @dataProvider valueProvider
     */
    public function testShouldBeAbleToLocateAValue(array $values)
    {
        $sut = new Set();

        array_walk_recursive($values, [$sut, "add"]);

        array_walk_recursive(
            $values,
            function ($value) use ($sut) {
                $this->assertEquals($value, $sut->get($value));
            }
        );
    }

    /**
     * @dataProvider valueProvider
     */
    public function testToArrayShouldHaveTheSameCardinalityAsTheSet(array $values)
    {
        $sut = new Set();

        array_walk_recursive($values, [$sut, "add"]);

        $this->assertEquals(count($sut), count($sut->toArray()));
    }

    public function testCountAndCardinalityAreTheSame()
    {
        $sut = new Set();

        $sut->add(1);
        $sut->add(2);
        $sut->add(3);

        $this->assertEquals($sut->count(), $sut->cardinality());
    }
}
