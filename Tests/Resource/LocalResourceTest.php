<?php

namespace Orbt\ResourceMirror\Tests\Resource;

use Orbt\ResourceMirror\Resource\LocalResource;

class LocalResourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A local resource can be instantiated.
     */
    public function testCreate()
    {
        $resource = new LocalResource('test', 'test content');
        $this->assertInstanceOf('Orbt\ResourceMirror\Resource\LocalResource', $resource);
    }

    /**
     * A local resource returns its content.
     *
     * @depends testCreate
     */
    public function testGetContent()
    {
        $resource = new LocalResource('test', 'test content');
        $this->assertEquals('test content', $resource->getContent());
    }

    /**
     * Content in a local resource is updated.
     *
     * @depends testGetContent
     */
    public function testSetContent()
    {
        $resource = new LocalResource('test', 'test content');
        $resource->setContent('new content');
        $this->assertEquals('new content', $resource->getContent());
    }
}
