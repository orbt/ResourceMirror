<?php

namespace Orbt\ResourceMirror;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Factory for creating resource mirror services.
 */
class ResourceMirrorFactory
{
    /**
     * Event dispatcher.
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Creates a factory object.
     *
     * @param EventDispatcherInterface $dispatcher
     *   Default event dispatcher for resource mirrors created by this factory.
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Creates a resource mirror.
     *
     * @param string $baseUrl
     *   Base URL of the mirror server, i.e. the server hosting resources materialized by the mirror.
     * @param string $directory
     *   Base directory used by the mirror.
     * @param EventDispatcherInterface $dispatcher
     *   Optional event dispatcher to override the dispatcher this factory was originally created with.
     * @return ResourceMirror
     *   A new resource mirror object.
     */
    public function createMirror($baseUrl, $directory, EventDispatcherInterface $dispatcher = NULL)
    {
        return new ResourceMirror(isset($dispatcher) ? $dispatcher : $this->dispatcher, $baseUrl, $directory);
    }
}
