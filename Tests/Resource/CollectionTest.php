<?php

namespace Orbt\ResourceMirror\Tests\Resource;

use Orbt\ResourceMirror\Resource\Collection;
use Orbt\ResourceMirror\Resource\GenericResource;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    const COLLECTION_CLASS = 'Orbt\ResourceMirror\Resource\Collection';

    /**
     * A resource collection can be instantiated.
     */
    public function testCreate()
    {
        $collection = new Collection();
        $this->assertInstanceOf(self::COLLECTION_CLASS, $collection);
    }

    /**
     * A new collection returns an empty list.
     *
     * @depends testCreate
     */
    public function testGetAll()
    {
        $collection = new Collection();
        $all = $collection->getAll();
        $this->assertTrue(is_array($all));
        $this->assertEmpty($all);
    }

    /**
     * A resource is added to a collection.
     *
     * @depends testCreate
     * @depends testGetAll
     */
    public function testAdd()
    {
        $resource = new GenericResource('test');
        $collection = new Collection();
        $collection->add($resource);
        $all = $collection->getAll();
        $this->assertCount(1, $all);
        $this->assertTrue(in_array($resource, $all));
    }

    /**
     * An invalid resource is not added to a collection.
     *
     * @depends testCreate
     * @expectedException \InvalidArgumentException
     */
    public function testAddInvalid()
    {
        $collection = new Collection();
        $collection->add(false);
    }

    /**
     * A resource is removed from a collection.
     *
     * @depends testAdd
     */
    public function testRemove()
    {
        $resource = new GenericResource('test');
        $collection = new Collection();
        $collection->add($resource);
        $collection->remove($resource);
        $all = $collection->getAll();
        $this->assertEmpty($all);
    }

    /**
     * A collection is iterable.
     *
     * @depends testAdd
     */
    public function testIterator()
    {
        $resource = new GenericResource('test');
        $collection = new Collection();
        $iterator = $collection->getIterator();
        $this->assertInstanceOf('Iterator', $iterator);
        foreach ($collection as $item) {
            $this->assertEquals($resource, $item);
            break;
        }
    }

    /**
     * A collection uses fluent interface for adding and removing resources.
     *
     * @depends testAdd
     * @depends testRemove
     */
    public function testFluentInterface()
    {
        $resource = new GenericResource('test');
        $collection = new Collection();
        $result = $collection->add($resource);
        $this->assertInstanceOf(self::COLLECTION_CLASS, $result);
        $result = $collection->remove($resource);
        $this->assertInstanceOf(self::COLLECTION_CLASS, $result);
    }
}
