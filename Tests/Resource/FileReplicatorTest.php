<?php

namespace Orbt\ResourceMirror\Tests;

use Orbt\ResourceMirror\Resource\FileReplicator;
use Orbt\ResourceMirror\Resource\GenericResource;

class FileReplicatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A file replicator can be instantiated.
     */
    public function testCreate()
    {
        $replicator = new FileReplicator('http://example.com/', sys_get_temp_dir());
        $this->assertInstanceOf('Orbt\ResourceMirror\Resource\FileReplicator', $replicator);
    }

    /**
     * A file replicator replicates a file from the base URL to the directory.
     */
    public function testReplicate()
    {
        $directory = $this->generateDirectory();
        $replicator = new FileReplicator('http://example.com/', $directory);
        $replicator->replicate(new GenericResource('test'));
        $file = $directory.'/test';
        $this->assertTrue(file_exists($file));
        $this->assertGreaterThan(0, filesize($file));
    }

    protected function generateDirectory()
    {
        do {
            $directory = sys_get_temp_dir().'/'.uniqid('FileReplicator');
        }
        while (file_exists($directory));
        mkdir($directory);
        return $directory;
    }
}
