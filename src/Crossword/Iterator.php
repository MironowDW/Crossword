<?php

namespace Crossword;

/**
 * Итератор для коллекции
 */
class Iterator implements \Iterator
{
    private $array = array();

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function rewind()
    {
        reset($this->array);
    }

    public function current()
    {
        return current($this->array);
    }

    public function key()
    {
        return key($this->array);
    }

    public function next()
    {
        return next($this->array);
    }

    public function valid()
    {
        $key = key($this->array);
        return ($key !== NULL && $key !== FALSE);
    }
}