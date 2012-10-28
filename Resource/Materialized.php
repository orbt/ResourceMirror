<?php

namespace Orbt\ResourceMirror\Resource;

/**
 * Resource interface indicated it has been materialized and its content can be retrieved.
 */
interface Materialized
{
    /**
     * Returns the content of the materialized resource.
     * @return mixed
     */
    public function getContent();
}
