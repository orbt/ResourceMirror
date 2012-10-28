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
        if (!strlen($path)) {
            throw new \InvalidArgumentException('Path must not be empty.');
        }
        if ($path[0] == '/') {
            throw new \InvalidArgumentException('Path must not be absolute.');
        }
        $this->path = rtrim($path, '/');
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }
}
