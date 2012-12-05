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
        if (!$source = @fopen($url, 'rb')) {
            throw new ReplicatorException(sprintf('Cannot open URL "%s" for reading.', $url));
        }
        $file = $this->directory.$resource->getPath();
        @mkdir(dirname($file), 0777, true);
        if (!$target = @fopen($file, 'wb')) {
            fclose($source);
            throw new ReplicatorException(sprintf('Cannot open local file "%s" for writing.', $file));
        }
        stream_copy_to_stream($source, $target);
        fclose($source);
        fclose($target);
    }
}
