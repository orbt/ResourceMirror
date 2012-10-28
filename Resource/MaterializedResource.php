<?php

namespace Orbt\ResourceMirror\Resource;

/**
 * A materialized resource with available content.
 */
class MaterializedResource extends GenericResource implements Materialized
{
    /**
     * Internal resource.
     * @var Resource
     */
    protected $resource;

    /**
     * Directory containing the resource.
     * @var string
     */
    protected $directory;

    /**
     * Constructs a materialized resource.
     *
     * @param Resource $resource
     *   Resource that has been materialized. If this is already materialized, then its internal resource is used.
     * @param string $directory
     *   Directory containing resource file.
     *
     * @throws \InvalidArgumentException
     *   If the resource is already materialized or does not exist.
     */
    public function __construct($resource, $directory)
    {
        if ($resource instanceof MaterializedResource) {
            throw new \InvalidArgumentException('Resource is already materialized.');
        }
        $this->resource = $resource;
        $this->path = $this->resource->getPath();
        $this->directory = rtrim($directory, '\\/');

        if (!file_exists($this->directory.'/'.$this->path)) {
            throw new \InvalidArgumentException('Resource does not exist.');
        }
    }

    /**
     * Returns the internal resource.
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return file_get_contents($this->getRealPath());
    }

    /**
     * Returns the path to the actual file.
     */
    public function getRealPath()
    {
        return realpath($this->directory.'/'.$this->path);
    }
}
