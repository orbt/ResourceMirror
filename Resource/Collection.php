<?php

namespace Orbt\ResourceMirror\Resource;

/**
 * A collection of resource objects.
 */
class Collection implements \IteratorAggregate
{
    /**
     * Resource collection array.
     * @var array
     */
    protected $collection = array();

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Adds a new resource.
     *
     * @param Resource $resource
     *   Resource object.
     * @return static
     *   This collection, for fluent interface.
     *
     * @throws \InvalidArgumentException
     *   If the given object is not a resource object.
     */
    public function add($resource)
    {
        if (!$resource instanceof Resource) {
            throw new \InvalidArgumentException('Resource has the wrong type.');
        }
        $this->collection[] = $resource;
        return $this;
    }

    /**
     * Removes a resource.
     *
     * @param Resource $resource
     *   Resource object to remove.
     * @return static
     *   This collection, for fluent interface.
     */
    public function remove($resource)
    {
        $keysToRemove = array_keys($this->collection, $resource, true);
        $this->collection = array_values(array_diff_key($this->collection, array_flip($keysToRemove)));
        return $this;
    }

    /**
     * Returns the collection.
     */
    public function getAll()
    {
        return $this->collection;
    }
}
