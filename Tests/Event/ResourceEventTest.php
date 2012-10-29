<?php

namespace Orbt\ResourceMirror\Tests\Event;

use Orbt\ResourceMirror\Event\ResourceEvent;
use Orbt\ResourceMirror\Resource\GenericResource;

class ResourceEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A resource event can be instantiated.
     */
    public function testCreate()
    {
        $event = new ResourceEvent(new GenericResource('test'));
        $this->assertInstanceOf('Orbt\ResourceMirror\Event\ResourceEvent', $event);
    }
}
