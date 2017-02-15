<?php

namespace Utils;

interface ArrayIteratorInterface
{

    /**
     * @desc return current element of the collection
     * @return object
     */
    public function current();

    /**
     * @desc return next object of collection
     * @return object
     */
    public function next();

    /**
     * @desc return current position key
     * @return int
     */
    public function key();

    /**
     * @desc check if current object is a valid element (is not empty)
     * @return bool
     */
    public function valid();

    /**
     * @desc return current position iterator to 0
     */
    public function rewind();
}