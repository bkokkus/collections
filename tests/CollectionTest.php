<?php

use PHPUnit\Framework\TestCase;

/**
 * Class CollectionTest
 *
 * @author Oğuz Han ÖZMEN <oushan16@gmail.com>
 */
class CollectionTest extends TestCase
{
    public function testConstructMethod()
    {
        $c = new \Chestnut\Collections();
        $this->assertInstanceOf(\Chestnut\Collections::class, $c);
    }

    public function testToArrayMethod()
    {
        $c = new \Chestnut\Collections();
        $this->assertSame([], $c->toArray());
    }

    public function testCreateMethod()
    {
        $c = \Chestnut\Collections::create(['a', 'b']);
        $this->assertInstanceOf(\Chestnut\Collections::class, $c);
    }

    public function testRangeMethodWithNumericValues()
    {
        $c = \Chestnut\Collections::range(1, 3);
        $this->assertInstanceOf(\Chestnut\Collections::class, $c);
        $this->assertEquals([1, 2, 3], $c->toArray());
    }

    public function testRangeMethodWithStringValues()
    {
        $c = \Chestnut\Collections::range('a', 'c');
        $this->assertInstanceOf(\Chestnut\Collections::class, $c);
        $this->assertEquals(['a', 'b', 'c'], $c->toArray());
    }

    public function testFirstMethod()
    {
        $c = new \Chestnut\Collections(['c', 'b', 'a']);
        $this->assertEquals('c', $c->first());
    }

    public function testLastMethod()
    {
        $c = new \Chestnut\Collections(['c', 'b', 'a']);
        $this->assertEquals('a', $c->last());
    }

    public function testSearchMethod()
    {
        $c = new \Chestnut\Collections(['c', 'b', 'a']);
        $this->assertEquals(1, $c->search('b'));
    }

    public function testRemoveMethod()
    {
        $c = new \Chestnut\Collections(['c', 'b', 'a']);
        $c->remove('b');
        $this->assertEquals(
            [0 => 'c', 2 => 'a'],
            $c->toArray()
        );
        $this->assertInstanceOf(\Chestnut\Collections::class, $c);
    }

    public function testAddMethod()
    {
        $c = new \Chestnut\Collections(['a', 'b']);
        $c->add('d');
        $this->assertEquals(
            ['a', 'b', 'd'],
            $c->toArray()
        );
        $this->assertInstanceOf(\Chestnut\Collections::class, $c);
    }
}