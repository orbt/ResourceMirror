<?php

namespace Orbt\ResourceMirror;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Orbt\ResourceMirror\Exception\ReplicatorException;
use Orbt\ResourceMirror\Event\ResourceMaterializeEvent;
use Orbt\ResourceMirror\Event\ResourceEvents;
use Orbt\ResourceMirror\Resource\Collection;
use Orbt\ResourceMirror\Exception\MaterializeException;
use Orbt\ResourceMirror\Resource\FileReplicator;
use Orbt\ResourceMirror\Resource\MaterializedResource;
use Orbt\ResourceMirror\Resource\LocalResource;

/**
 * Main service for materializing services.
 */
class ResourceMirror
{
    /**
     * Event dispatcher.
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Mirror base URL.
     * @var string
     */
    protected $baseUrl;

    /**
     * Base resource directory.
     * @var string
     */
    protected $directory;

    /**
     * Resource replicator.
     * @var Resource\Replicator
     */
    protected $replicator;

    /**
     * Creates a new resource mirror.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     *   Event dispatcher.
     * @param string $baseUrl
     *   Base URL for the backend.
     * @param string $directory
     *   Path to the base directory to materialize resources to.
     *
     * @throws \InvalidArgumentException
     *   If the given directory is not writable.
     */
    public function __construct(EventDispatcherInterface $dispatcher, $baseUrl, $directory)
    {
        $this->dispatcher = $dispatcher;
        $this->baseUrl = $baseUrl;

        if (!is_dir($directory) || !is_writable($directory)) {
            throw new \InvalidArgumentException('Directory is not writable.');
        }
        $this->directory = rtrim($directory, '\\/');
    }

    /**
     * Returns the base URL of resources to mirror.
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Returns the base directory used by this mirror.
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Sets a resource replicator to use when materializing.
     * @param Resource\Replicator $replicator
     */
    public function setReplicator($replicator)
    {
        $this->replicator = $replicator;
    }

    /**
     * Returns the replicator used.
     * @return Resource\Replicator
     */
    public function getReplicator()
    {
        if (!isset($this->replicator)) {
            $this->replicator = $this->createReplicator();
        }
        return $this->replicator;
    }

    /**
     * Creates a replicator.
     */
    protected function createReplicator()
    {
        return new FileReplicator($this->baseUrl, $this->directory);
    }

    /**
     * Materializes a collection of resources.
     *
     * @param Collection $collection
     *   Resource collection to materialize.
     * @return Collection
     *   A collection of materialized resources.
     */
    public function materializeCollection($collection)
    {
        $materializedCollection = new Collection();
        foreach ($collection as $resource) {
            $materializedCollection->add($this->materialize($resource));
        }
        return $materializedCollection;
    }

    /**
     * Materializes a resource.
     *
     * @param Resource\Resource $resource
     *   Resource to materialize.
     * @param bool $overwrite
     *   Whether to overwrite a resource if it already exists.
     * @return Resource\MaterializedResource
     *   Materialized resource container, or the given resource if already materialized.
     *
     * @throws MaterializeException
     *   If the resource cannot be materialized.
     */
    public function materialize($resource, $overwrite = false)
    {
        if ($resource instanceof MaterializedResource) {
            return $resource;
        }

        if ($overwrite || !$this->exists($resource)) {
            try {
                $this->getReplicator()->replicate($resource);
            }
            catch (ReplicatorException $e) {
                throw new MaterializeException(sprintf('Cannot materialize resource: %s', $e->getMessage()), 0, $e);
            }
            $materialized = true;
        }

        $materializedResource = new MaterializedResource($resource, $this->getDirectory());
        if (!empty($materialized)) {
            $this->dispatcher->dispatch(ResourceEvents::MATERIALIZE, new ResourceMaterializeEvent($materializedResource));
        }

        return $materializedResource;
    }

    /**
     * Stores a local resource. Existing files are overwritten.
     *
     * @param LocalResource $resource
     * @return MaterializedResource
     *
     * @throws \InvalidArgumentException
     *   If given resource is not local.
     */
    public function store($resource)
    {
        if (!$resource instanceof LocalResource) {
            throw new \InvalidArgumentException('Resource is not local.');
        }

        $file = $this->directory.'/'.$resource->getPath();
        @mkdir(dirname($file), 0777, true);
        file_put_contents($file, $resource->getContent());
        return new MaterializedResource($resource, $this->directory);
    }

    /**
     * Returns whether the specified resource already exists.
     *
     * @param Resource\Resource $resource
     * @return bool
     */
    public function exists($resource)
    {
        return file_exists($this->getDirectory().'/'.$resource->getPath());
    }
}
