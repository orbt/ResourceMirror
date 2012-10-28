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
     * Base resource directory.
     * @var string
     */
    protected $directory;

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
        $this->baseUrl = rtrim($baseUrl, '\\/').'/';

        if (!is_dir($directory) || !is_writable($directory)) {
            throw new \InvalidArgumentException('Directory is not writable.');
        }
        $this->directory = $directory;
    }

    /**
     * Returns the base URL of this mirror.
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
}
