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
     * A generic resource is not created for an absolute path.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateAbsolutePath()
    {
        new GenericResource('/path');
    }

    /**
     * A generic resource is not created for a path with a trailing slash.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreatePathTrailingSlash()
    {
        new GenericResource('path/');
    }

    /**
     * A generic resource is not created for denormalized path.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateDenormalizedPath()
    {
        new GenericResource('a/../b');
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

    /**
     * A generic resource returns an array of path segments.
     *
     * @depends testCreate
     */
    public function testGetPathSegments()
    {
        $resource = new GenericResource('a/b');
        $this->assertEquals(array('a', 'b'), $resource->getPathSegments());
        $resource = new GenericResource('');
        $this->assertEmpty($resource->getPathSegments());
    }

    /**
     * A generic resource resolves a relative path.
     *
     * @depends testCreate
     */
    public function testResolvePath()
    {
        $resource = new GenericResource('test');
        $path = $resource->resolvePath('a/../../../b/./c');
        $this->assertEquals('../../b/c', $path);
        $resource = new GenericResource('');
        $this->assertEquals('a', $resource->resolvePath('a'));
        $this->assertEquals('../a', $resource->resolvePath('../a'));
    }

    /**
     * A generic resource does not resolve an absolute path.
     *
     * @depends testCreate
     * @expectedException \InvalidArgumentException
     */
    public function testResolveAbsolutePath()
    {
        $resource = new GenericResource('test');
        $resource->resolvePath('/absolute');
    }
}
