<?php

namespace Orbt\ResourceMirror\Tests;

use Orbt\ResourceMirror\ResourceMirror;
use Orbt\ResourceMirror\Resource\MaterializedResource;
use Orbt\ResourceMirror\Tests\Fixtures\ResourceEventSubscriber;
use Orbt\ResourceMirror\Resource\Collection;
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

    /**
     * A resource mirror materializes a resource.
     *
     * @depends testCreate
     */
    public function testMaterialize()
    {
        $directory = $this->generateDirectory();
        $resource = new GenericResource('test');
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', $directory);
        $mirror->materialize($resource);
        $this->assertTrue($mirror->exists($resource));
    }

    /**
     * A resource mirror does not act on an already materialized resource.
     *
     * @depends testCreate
     */
    public function testMaterializeExisting()
    {
        $directory = sys_get_temp_dir();
        touch($directory.'/test');
        $resource = new MaterializedResource(new GenericResource('test'), $directory);
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', $directory);
        $result = $mirror->materialize($resource);
        $this->assertTrue($result === $resource);
    }

    /**
     * A resource mirror materializes a collection of resources.
     *
     * @depends testCreate
     */
    public function testMaterializeCollection()
    {
        $directory = $this->generateDirectory();
        $resource = new GenericResource('test');
        $collection = new Collection();
        $collection->add($resource);
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', $directory);
        $mirror->materializeCollection($collection);
        $this->assertTrue($mirror->exists($resource));
    }

    /**
     * A resource mirror dispatches a resource materialize event.
     */
    public function testMaterializeEvent()
    {
        $dispatcher = new EventDispatcher();
        $subscriber = new ResourceEventSubscriber();
        $dispatcher->addSubscriber($subscriber);
        $directory = $this->generateDirectory();
        $resource = new GenericResource('test');
        $mirror = new ResourceMirror($dispatcher, 'http://example.com/', $directory);
        $materializedResource = $mirror->materialize($resource);
        $this->assertEquals($materializedResource, reset($subscriber->resources));
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
