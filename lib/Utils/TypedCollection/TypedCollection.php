<?php

namespace Utils\TypedCollection;

use Utils\ArrayIteratorInterface;

/**
 * Implementation of Java-similar collection design pattern
 * @package TypedCollection
 */
class TypedCollection implements \IteratorAggregate, \Countable, ArrayIteratorInterface
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var array
     */
    private $collection = [];
    /**
     * @var int
     */
    private $position = 0;

    /**
     * TypedCollection constructor.
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * @return object
     */
    public function current()
    {
        return $this->collection[$this->position];
    }

    /**
     *
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {

        return !empty($this->collection[$this->position]);
    }

    /**
     *
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return object
     */
    public function first()
    {
        return $this->collection[0];
    }

    /**
     * @return object
     */
    public function last()
    {
        return $this->collection[$this->count() -1];
    }

    /**
     * Add element of type to the collection
     * @param object $element
     * @throws TypedCollectionException
     */
    public function add($element)
    {
        if (is_a($element, $this->type)) {
            $this->collection[] = $element;
        } else {
            throw TypedCollectionException::createWithInvalidType();
        }
    }

}