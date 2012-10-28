<?php

namespace Orbt\ResourceMirror\Event;
use Orbt\ResourceMirror\Resource\Materialized;

/**
 * Resource materialize event.
 */
class ResourceMaterializeEvent extends ResourceEvent
{
    public function __construct($resource)
    {
        if (!$resource instanceof Materialized) {
            throw new \InvalidArgumentException('Resource is not materialized.');
        }
        $this->resource = $resource;
    }
}
