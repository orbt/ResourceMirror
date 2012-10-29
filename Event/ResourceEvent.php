<?php

namespace Orbt\ResourceMirror\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event for a resource triggered by the resource mirror.
 */
class ResourceEvent extends Event
{
    /**
     * @var Resource
     */
    protected $resource;

    /**
     * Constructs a resource event.
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Returns the resource for this event.
     */
    public function getResource()
    {
        return $this->resource;
    }
}
