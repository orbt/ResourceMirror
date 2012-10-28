<?php

namespace Orbt\ResourceMirror\Tests\Resource;

use Orbt\ResourceMirror\Resource\GenericResource;

class GenericResourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A generic resource can be instantiated.
     */
    public function testCreate()
    {
        $resource = new GenericResource('test');
        $this->assertInstanceOf('Orbt\ResourceMirror\Resource\GenericResource', $resource);
    }

    /**
     * A generic resource returns the resource path.
     *
     * @depends testCreate
     */
    public function testGetPath()
    {
        $resource = new GenericResource('test');
        $this->assertEquals('test', $resource->getPath());
    }
}
