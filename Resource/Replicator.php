<?php

namespace Orbt\ResourceMirror\Resource;

/**
 * Interface for a resource handler fetching and writing resources to file.
 *
 * A replicator implementation should implicitly handle the internal directory.
 */
interface Replicator
{
    /**
     * Fetches and writes a resource.
     *
     * @param Resource $resource
     *   Resource to fetch and write.
     *
     * @throws \Orbt\ResourceMirror\Exception\ReplicatorException
     */
    public function replicate($resource);
}
