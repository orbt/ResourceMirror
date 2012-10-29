<?php

namespace Orbt\ResourceMirror\Tests;

use Orbt\ResourceMirror\ResourceMirror;
use Orbt\ResourceMirror\Resource\GenericResource;
use Orbt\ResourceMirror\Resource\FileReplicator;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ResourceMirrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A resource mirror can be instantiated.
     */
    public function testCreate()
    {
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', sys_get_temp_dir());
        $this->assertInstanceOf('Orbt\ResourceMirror\ResourceMirror', $mirror);
    }

    /**
     * A resource mirror returns the base URL.
     *
     * @depends testCreate
     */
    public function testGetBaseUrl()
    {
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', sys_get_temp_dir());
        $this->assertEquals('http://example.com/', $mirror->getBaseUrl());
    }

    /**
     * A resource mirror returns the directory.
     *
     * @depends testCreate
     */
    public function testGetDirectory()
    {
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', $tempDir = sys_get_temp_dir());
        $this->assertEquals($tempDir, $mirror->getDirectory());
    }

    /**
     * A resource mirror is not created if directory is not writable.
     *
     * @depends testCreate
     * @expectedException \InvalidArgumentException
     */
    public function testCreateBadDirectory()
    {
        new ResourceMirror(new EventDispatcher(), 'http://example.com/', '/a/probably/not/writable/directory');
    }

    /**
     * A resource mirror returns an automatically created replicator.
     *
     * @depends testCreate
     */
    public function testGetReplicator()
    {
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', sys_get_temp_dir());
        $replicator = $mirror->getReplicator();
        $this->assertInstanceOf('Orbt\ResourceMirror\Resource\Replicator', $replicator);
    }

    /**
     * A resource mirror can use a different replicator.
     *
     * @depends testGetReplicator
     */
    public function testSetReplicator()
    {
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', sys_get_temp_dir());
        $replicator = $mirror->getReplicator();
        $mirror->setReplicator(new FileReplicator('http://different.com/', sys_get_temp_dir()));
        $this->assertNotEquals($replicator, $mirror->getReplicator());
    }

    /**
     * A resource mirror determines whether a resource exists.
     *
     * @depends testCreate
     */
    public function testExists()
    {
        $directory = $this->generateDirectory();
        $resource = new GenericResource('test');
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', $directory);
        $this->assertFalse($mirror->exists($resource));
        touch($directory.'/test');
        $this->assertTrue($mirror->exists($resource));
    }

    protected function generateDirectory()
    {
        do {
            $directory = sys_get_temp_dir().'/'.uniqid('FileReplicator');
        }
        while (file_exists($directory));
        mkdir($directory);
        return $directory;
    }
}
