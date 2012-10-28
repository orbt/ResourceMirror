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
     */
    public function testGetBaseUrl()
    {
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', sys_get_temp_dir());
        $this->assertEquals('http://example.com/', $mirror->getBaseUrl());
    }

    /**
     * A resource mirror returns the directory.
     */
    public function testGetDirectory()
    {
        $mirror = new ResourceMirror(new EventDispatcher(), 'http://example.com/', $tempDir = sys_get_temp_dir());
        $this->assertEquals($tempDir, $mirror->getDirectory());
    }
}
