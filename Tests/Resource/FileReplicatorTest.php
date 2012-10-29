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
     *
     * @depends testCreate
     */
    public function testReplicate()
    {
        $directory = $this->generateDirectory();
        $replicator = new FileReplicator('http://example.com/', $directory);
        $replicator->replicate(new GenericResource('test/nested'));
        $file = $directory.'/test/nested';
        $this->assertTrue(file_exists($file));
        $this->assertGreaterThan(0, filesize($file));
    }

    /**
     * A file replicator does not replicate from a bad base URL.
     *
     * @depends testCreate
     * @expectedException \Orbt\ResourceMirror\Exception\ReplicatorException
     */
    public function testReplicateBadBaseUrl()
    {
        $replicator = new FileReplicator('invalid://invalid/', sys_get_temp_dir());
        $replicator->replicate(new GenericResource('test'));
    }

    /**
     * A file replicator does not replicate to a bad directory.
     *
     * @depends testCreate
     * @expectedException \Orbt\ResourceMirror\Exception\ReplicatorException
     */
    public function testReplicateBadDirectory()
    {
        $replicator = new FileReplicator('http://example.com/', '/@%%:;5#_+');
        $replicator->replicate(new GenericResource('test'));
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
