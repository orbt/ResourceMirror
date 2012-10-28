<?php

namespace Orbt\ResourceMirror\Tests;

use Orbt\ResourceMirror\ResourceMirrorFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ResourceMirrorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A resource mirror factory can be instantiated.
     */
    public function testCreate()
    {
        $factory = new ResourceMirrorFactory(new EventDispatcher());
        $this->assertInstanceOf('Orbt\ResourceMirror\ResourceMirrorFactory', $factory);
    }

    /**
     * A resource mirror factory creates a resource mirror.
     */
    public function testCreateMirror()
    {
        $factory = new ResourceMirrorFactory(new EventDispatcher());
        $mirror = $factory->createMirror('http://example.com/', sys_get_temp_dir());
        $this->assertInstanceOf('Orbt\ResourceMirror\ResourceMirror', $mirror);
    }
}
