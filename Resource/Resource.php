<?php

namespace Orbt\ResourceMirror\Resource;

/**
 * Basic interface for a resource that can be mirrored.
 */
interface Resource
{
    /**
     * Returns the path of this resource.
     * @return string
     */
    public function getPath();
}
