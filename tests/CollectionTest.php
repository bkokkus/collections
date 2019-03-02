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

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testValidMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        foreach ($c->toArray() as $key => $value) {
            $c->next();
            $this->assertEquals(isset($array[$c->key()]), $c->valid());
        }
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testToJsonMethodWithPrettyPrint(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $this->assertJson($c->toJson());
        $this->assertEquals(
            json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            $c->toJson()
        );
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testToJsonMethodWithoutPrettyPrint(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $this->assertJson($c->toJson(false));
        $this->assertEquals(
            json_encode($array, JSON_UNESCAPED_UNICODE),
            $c->toJson(false)
        );
    }

    public function test__ToStringMethod()
    {
        $c = new \Chestnut\Collections([1 => 'a', 2 => 'b']);
        $this->assertJson((string)$c);
        $this->assertEquals($c->toJson(false), (string)$c);
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testMergeMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $mergedC = $c->merge(['a', 'y', 'z']);
        $this->assertEquals(
            array_merge($array, ['a', 'y', 'z']),
            $mergedC->toArray()
        );

        $this->assertNotSame($c, $mergedC);
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testChunkMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $chunkedC = $c->chunk(2);
        $this->assertEquals(
            array_chunk($array, 2),
            $chunkedC->toArray()
        );
        $this->assertNotSame($c, $chunkedC);
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testOffsetSetWithoutOffsetMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $c[] = 'Element 1';
        $this->assertContains('Element 1', $c->toArray());
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testOffsetSetWithOffsetMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $c['Offset 1'] = 'Element 1';
        $this->assertArrayHasKey('Offset 1', $c->toArray());
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testOffsetExistsMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $this->assertEquals(isset($array['foo']), isset($c['foo']));
    }

    public function testOffsetGetMethod()
    {
        $c = new \Chestnut\Collections(['foo' => 'bar']);
        $this->assertEquals('bar', $c['foo']);
        $this->assertEquals(null, $c['baz']);
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testOffsetUnsetMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        unset($c['foo']);
        $this->assertArrayNotHasKey('foo', $c->toArray());
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testCountMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $this->assertCount(count($array), $c);
    }

    public function testGetMethod()
    {
        $c = new \Chestnut\Collections(['a' => 'b']);
        $this->assertEquals('b', $c->get('a'));
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testSetMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $c->set('b', 'c');
        $array['b'] = 'c';
        $this->assertEquals($array, $c->toArray());
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testMapMethod(array $array)
    {
        $func = function ($item) {
            return 'mapped_' . $item;
        };
        $c = new \Chestnut\Collections($array);
        $mappedC = $c->map($func);
        $mappedArray = array_map($func, $array);
        $this->assertEquals(
            $mappedArray,
            $mappedC->toArray()
        );
        $this->assertNotSame($c, $mappedC);
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testDiffMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $diffedC = $c->diff(['bar']);
        $this->assertEquals(
            array_diff($array, ['bar']),
            $diffedC->toArray()
        );
        $this->assertNotSame($c, $diffedC);
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testFlipMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $flippedC = $c->flip();
        $this->assertEquals(
            array_flip($array),
            $flippedC->toArray()
        );
        $this->assertNotSame($c, $flippedC);
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testShuffleMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $shuffledC = $c->shuffle();
        shuffle($array);
        $this->assertSame($c, $shuffledC);
        $this->assertSameSize($array, $shuffledC->toArray());
    }

    /**
     * @dataProvider arrayProvider
     * @param array $array
     */
    public function testReverseMethod(array $array)
    {
        $c = new \Chestnut\Collections($array);
        $reversedC = $c->reverse();
        $reversedArray = array_reverse($array);
        $this->assertEquals($reversedArray, $reversedC->toArray());
    }

    public function arrayProvider(): array
    {
        return [
            'empty' => [
                [],
            ],
            'indexed' => [
                [
                    1 => 'foo',
                    2 => 'bar',
                    3 => 'baz',
                ],
            ],
            'assoc' => [
                [
                    'foo' => 1,
                    'bar' => 2,
                    'baz' => 3,
                ],
            ],
            'mixed' => [
                [
                    1 => 'foo',
                    'bar' => 2,
                    'baz' => 'three',
                ],
            ],
        ];
    }
}