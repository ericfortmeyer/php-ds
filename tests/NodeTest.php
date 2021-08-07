<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use PhpDs\Node;

class NodeTest extends TestCase
{
    public function testReturnsExpectedValue()
    {
        $testValue = "beans";
        $sut = new class($testValue) extends Node {
            public function getValue(): string
            {
                return $this->value;
            }
        };

        $this->assertEquals($testValue, $sut->getValue());
    }
}
