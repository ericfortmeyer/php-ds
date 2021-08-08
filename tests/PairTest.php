<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use PhpDs\Pair;

class PairTest extends TestCase
{
    public function keyValueProvider()
    {
        $floats = range(1e-4, 10e-3, 10e-4);
        return 
            [
                [ random_int(PHP_INT_MIN, PHP_INT_MAX), base64_encode(random_bytes(8)) ],
                [ base64_encode(random_bytes(8)), random_int(PHP_INT_MIN, PHP_INT_MAX) ],
                [ fn () => null, null ],
                [ null, fn () => null ],
                [ (object)"", $floats[array_rand($floats)] ]
            ];
    }

    public function singleValueAssocArrayProvider()
    {
        $floats = range(1e-4, 10e-3, 10e-4);
        return 
            [
                [ [ random_int(PHP_INT_MIN, PHP_INT_MAX) => base64_encode(random_bytes(8)) ] ],
                [ [ base64_encode(random_bytes(8)) => random_int(PHP_INT_MIN, PHP_INT_MAX) ] ],
                [ [ join(range("a", "z")) => null ] ],
                [ [ null => fn () => null ] ],
                [ [ join(range("A", "Z")) => $floats[array_rand($floats)] ] ]
            ];
    }

    public function tupleProvider()
    {
        $floats = range(1e-4, 10e-3, 10e-4);
        return 
            [
                [ [ random_int(PHP_INT_MIN, PHP_INT_MAX), base64_encode(random_bytes(8)) ] ],
                [ [ base64_encode(random_bytes(8)), random_int(PHP_INT_MIN, PHP_INT_MAX) ] ],
                [ [ fn () => null, null ] ],
                [ [ null, fn () => null ] ],
                [ [ (object)"", $floats[array_rand($floats)] ] ]
            ];
    }

    public function singleValueProvider()
    {
        $floats = range(1e-4, 10e-3, 10e-4);
        return 
            [
                [ [ random_int(PHP_INT_MIN, PHP_INT_MAX) ] ],
                [ [ base64_encode(random_bytes(8)) ] ],
                [ [ $floats[array_rand($floats)]] ],
                [ [ fn () => null ] ],
                [ [ null ] ],
                [ [ (object)"" ] ]
            ];
    }

    public function tooManyArgsProvider()
    {
        return [
            [ range(1, random_int(3, 8)) ]
        ];
    }

    /**
     * @dataProvider keyValueProvider
     */
    public function testReturnsGivenKey($key, $value)
    {
        $sut = new Pair($key, $value);

        $this->assertEquals($key, $sut->getKey());
    }

    /**
     * @dataProvider keyValueProvider
     */
    public function testReturnsGivenValue($key, $value)
    {
        $sut = new Pair($key, $value);

        $this->assertEquals($value, $sut->getValue());
    }

    /**
     * @dataProvider singleValueAssocArrayProvider
     */
    public function testReturnsKeyAndValueWhenUsingFromSingleValueAssocArrayToCreatePair($pair)
    {
        $key = key($pair);
        $value = current($pair);

        $sut = Pair::fromSingleValueAssocArray($pair);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($value, $sut->getValue());
    }

    /**
     * @dataProvider tupleProvider
     */
    public function testReturnsKeyAndValueWhenUsingFromTupleToCreatePair($tuple)
    {
        [$key, $value] = $tuple;

        $sut = Pair::fromTuple($tuple);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($value, $sut->getValue());
    }

    public function testThrowsExceptionWhenFromArrayReceivesAnEmptyArray()
    {
        $this->expectException(InvalidArgumentException::class);

        Pair::fromSingleValueAssocArray([]);
    }

    public function testFromTupleThrowsExceptionWhenGivenAnEmptyArray()
    {
        $this->expectException(InvalidArgumentException::class);

        Pair::fromTuple([]);
    }

    /**
     * @dataProvider singleValueProvider
     */
    public function testFromTupleThrownExceptionWhenGivenSingleValueArray(array $singleValueArray)
    {
        $this->expectException(InvalidArgumentException::class);

        Pair::fromTuple($singleValueArray);
    }

    /**
     * @dataProvider tupleProvider
     */
    public function testFromSingleValueAssocArrayThrowsExceptionWhenGivenTuple(array $tuple)
    {
        $this->expectException(InvalidArgumentException::class);

        Pair::fromSingleValueAssocArray($tuple);
    }

    /**
     * @dataProvider tooManyArgsProvider
     */
    public function testFromSingleValueAssocArrayThrowsExceptionWhenGivenTooManyArgs(array $tooManyArgs)
    {
        $this->expectException(InvalidArgumentException::class);

        Pair::fromSingleValueAssocArray($tooManyArgs);
    }

    /**
     * @dataProvider tooManyArgsProvider
     */
    public function testFromTupleThrowsExceptionWhenGivenTooManyArgs(array $tooManyArgs)
    {
        $this->expectException(InvalidArgumentException::class);

        Pair::fromTuple($tooManyArgs);
    }
}
