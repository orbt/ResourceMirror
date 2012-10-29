<?php

namespace Orbt\ResourceMirror\Tests\Event;

use Orbt\ResourceMirror\Event\ResourceMaterializeEvent;
use Orbt\ResourceMirror\Resource\GenericResource;
use Orbt\ResourceMirror\Resource\MaterializedResource;

class ResourceMaterializeEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A resource materialize event can be instantiated.
     */
    public function testCreate()
    {
        $directory = sys_get_temp_dir();
        touch($directory.'/test');
        $resource = new MaterializedResource(new GenericResource('test'), $directory);
        $event = new ResourceMaterializeEvent($resource);
        $this->assertInstanceOf('Orbt\ResourceMirror\Event\ResourceEvent', $event);
    }

    /**
     * A resource materialize event is not created from a non-materialized resource.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateInvalid()
    {
        new ResourceMaterializeEvent(new GenericResource('test'));
    }
}
