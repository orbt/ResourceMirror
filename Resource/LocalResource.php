<?php

namespace Orbt\ResourceMirror\Resource;

/**
 * A resource that exists locally, i.e. not on the backend server.
 *
 * A local resource contains content to be managed, not materialized.
 */
class LocalResource extends GenericResource
{
    /**
     * Resource content.
     * @var string
     */
    protected $content;

    /**
     * Creates a local resource with content.
     *
     * @param string $path
     *   Resource path.
     * @param $content
     *   Resource content.
     */
    public function __construct($path, $content)
    {
        parent::__construct($path);
        $this->content = $content;
    }

    /**
     * Updates resource content.
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Returns resource content.
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
