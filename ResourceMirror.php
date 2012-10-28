<?php

namespace Orbt\ResourceMirror;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
     * Creates a new resource mirror.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     *   Event dispatcher.
     * @param string $baseUrl
     *   Base URL for the backend.
     */
    public function __construct(EventDispatcherInterface $dispatcher, $baseUrl)
    {
        $this->dispatcher = $dispatcher;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Returns the base URL of this mirror.
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
