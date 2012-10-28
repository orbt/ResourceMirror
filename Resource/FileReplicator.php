<?php

namespace Orbt\ResourceMirror\Resource;
use Orbt\ResourceMirror\Exception\ReplicatorException;

/**
 * Basic replicator implementation using file operations to replicate.
 */
class FileReplicator implements Replicator
{
    /**
     * Base URL.
     * @var string
     */
    protected $baseUrl;

    /**
     * Target directory.
     * @var string
     */
    protected $directory;

    /**
     * Constructs a file replicator.
     */
    public function __construct($baseUrl, $directory)
    {
        $this->baseUrl = rtrim($baseUrl, '/').'/';
        $this->directory = rtrim($directory, '\\/').'/';
    }

    /**
     * {@inheritdoc}
     */
    public function replicate($resource)
    {
        $url = $this->baseUrl.$resource->getPath();
        if (!$source = @fopen($url, 'r')) {
            throw new ReplicatorException('Cannot open URL for reading.');
        }
        $file = $this->directory.$resource->getPath();
        if (!$target = @fopen($file, 'w')) {
            fclose($source);
            throw new ReplicatorException('Cannot open local file for writing.');
        }
        stream_copy_to_stream($source, $target);
        fclose($source);
        fclose($target);
    }
}
