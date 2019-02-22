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
}