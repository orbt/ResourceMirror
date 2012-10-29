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
     *
     * @param string $path
     *   Normalized relative path.
     *
     * @throws \InvalidArgumentException
     *   If the path is empty, absolute, or denormalized.
     */
    public function __construct($path)
    {
        if (strlen($path)) {
            if ($path[0] == '/') {
                throw new \InvalidArgumentException('Path must not be absolute.');
            }
            if (substr($path, -1) == '/') {
                throw new \InvalidArgumentException('Path must not have a trailing slash.');
            }
            if (strpos($path, '..') !== false) {
                throw new \InvalidArgumentException('Path must be normalized.');
            }
        }
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns an array of path segments (split by delimiter '/').
     */
    public function getPathSegments()
    {
        return strlen($this->path) ? explode('/', $this->path) : array();
    }

    /**
     * Resolves a relative path based on the path of this resource.
     */
    public function resolvePath($path)
    {
        if ($path[0] == '/') {
            throw new \InvalidArgumentException('Cannot resolve absolute path.');
        }

        $segments = $this->getPathSegments();
        if (!empty($segments)) {
            // Remove the last segment for relative paths.
            array_pop($segments);
        }
        $path = trim($path, '/');
        foreach (explode('/', trim($path, '/')) as $segment) {
            if ($segment == '.') {
                continue;
            }
            elseif ($segment == '..' && !empty($segments) && end($segments) != '..') {
                array_pop($segments);
            }
            else {
                $segments[] = $segment;
            }
        }

        return implode('/', $segments);
    }
}
