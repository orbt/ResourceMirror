<?php

namespace Orbt\ResourceMirror\Tests;

use Orbt\ResourceMirror\ResourceMirror;
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
}
