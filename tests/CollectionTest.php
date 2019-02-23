<?php

use PHPUnit\Framework\TestCase;

/**
 * Class CollectionTest
 *
 * @author Oğuz Han ÖZMEN <oushan16@gmail.com>
 * @author Bekir KÖKKUŞ <bekirkokkus@gmail.com>
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

    public function testCurrentMethod()
    {
        $c = new \Chestnut\Collections(['a', 'b']);
        $this->assertEquals('a', $c->current());
    }

    public function testNextMethod()
    {
        $c = new \Chestnut\Collections(['a', 'b']);
        $c->next();
        $this->assertEquals('b', $c->current());
    }

    public function testKeyMethod()
    {
        $c = new \Chestnut\Collections(['key_1' => 'a', 'key_2' => 'b']);
        $c->next();
        $this->assertEquals('key_2', $c->key());
    }

    public function testRewindMethod()
    {
        $c = new \Chestnut\Collections(['key_1' => 'a', 'key_2' => 'b']);
        $c->next();
        $this->assertEquals('key_2', $c->key());
        $c->rewind();
        $this->assertEquals('key_1', $c->key());
    }

    public function testValidMethod()
    {
        $c = new \Chestnut\Collections(['key_1' => 'a', 'key_2' => 'b']);
        $c->next();
        $this->assertTrue($c->valid());
        $c->next();
        $this->assertFalse($c->valid());
    }

    public function testToJsonMethodWithPrettyPrint()
    {
        $c = new \Chestnut\Collections([1 => 'a', 2 => 'b']);
        $this->assertJson($c->toJson());
        $this->assertEquals(
            "{\n    \"1\": \"a\",\n    \"2\": \"b\"\n}",
            $c->toJson()
        );
    }

    public function testToJsonMethodWithoutPrettyPrint()
    {
        $c = new \Chestnut\Collections([1 => 'a', 2 => 'b']);
        $this->assertJson($c->toJson(false));
        $this->assertEquals(
            "{\"1\":\"a\",\"2\":\"b\"}",
            $c->toJson(false)
        );
    }

    public function test__ToStringJsonMethod()
    {
        $c = new \Chestnut\Collections([1 => 'a', 2 => 'b']);
        $this->assertJson((string)$c);
        $this->assertEquals($c->toJson(false), (string)$c);
    }
}