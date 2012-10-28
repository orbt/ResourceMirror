<?php

namespace Orbt\ResourceMirror\Tests\Resource;

use Orbt\ResourceMirror\Resource\MaterializedResource;
use Orbt\ResourceMirror\Resource\GenericResource;

class MaterializedResourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A materialized resource can be instantiated.
     */
    public function testCreate()
    {
        $directory = sys_get_temp_dir();
        $resource = new MaterializedResource($this->getFileResource($directory), $directory);
        $this->assertInstanceOf('Orbt\ResourceMirror\Resource\MaterializedResource', $resource);
    }

    /**
     * A materialized resource is not created from another materialized resource.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateMaterialized()
    {
        $directory = sys_get_temp_dir();
        $resource = new MaterializedResource($this->getFileResource($directory), $directory);
        new MaterializedResource($resource, $directory);
    }

    /**
     * A materialized resource is not created for a non-existent file.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateInvalidFile()
    {
        new MaterializedResource(new GenericResource('file_not_found.txt'), '/probably/not/a/directory');
    }

    /**
     * A materialized resource returns its internal resource.
     *
     * @depends testCreate
     */
    public function testGetResource()
    {
        $directory = $directory = sys_get_temp_dir();
        $fileResource = $this->getFileResource($directory);
        $resource = new MaterializedResource($fileResource, $directory);
        $this->assertEquals($fileResource, $resource->getResource());
    }

    /**
     * A materialized resource returns its real file path.
     *
     * @depends testCreate
     */
    public function testGetRealPath()
    {
        $directory = sys_get_temp_dir();
        $fileResource = $this->getFileResource($directory);
        $resource = new MaterializedResource($fileResource, $directory);
        $realpath = realpath($directory.'/'.$fileResource->getPath());
        $this->assertEquals($realpath, $resource->getRealPath());
    }

    /**
     * A materialized resource returns its content.
     *
     * @depends testCreate
     */
    public function testGetContent()
    {
        $directory = sys_get_temp_dir();
        $fileResource = $this->getFileResource($directory, 'testGetContent');
        $resource = new MaterializedResource($fileResource, $directory);
        $this->assertEquals('testGetContent', $resource->getContent());
    }

    /**
     * Creates a resource with a dummy file.
     */
    protected function getFileResource($directory, $content = 'test content')
    {
        $file = $this->randomFileName($directory, 'MaterialiedResourceTest');
        file_put_contents($directory.'/'.$file, $content);
        return new GenericResource($file);
    }

    /**
     * Generates a random new file name in a directory.
     */
    protected function randomFileName($directory, $prefix = '', $extension = '.txt')
    {
        do {
            $file = uniqid($prefix).$extension;
        }
        while (file_exists($directory.'/'.$file));
        return $file;
    }
}
