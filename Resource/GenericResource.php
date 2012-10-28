<?php

namespace Orbt\ResourceMirror\Resource;

/**
 * Generic resource containing just a relative path.
 */
class GenericResource implements Resource
{
    /**
     * Resource path.
     * @var string
     */
    protected $path;

    /**
     * Creates a generic resource with a path.
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }
}
