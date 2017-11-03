<?php

namespace Crossword;

use \Crossword\Line\Column;
use \Crossword\Line\Row;

/**
 * Поле кроссворда
 */
class Field
{
    /**
     * @var Column
     */
    protected $column;

    /**
     * @var string
     */
    protected $char = null;

    /**
     * @var bool
     */
    protected $isBlock = false;

    /**
     * @var Row
     */
    protected $row;

    /**
     * List of words which started in field (for render number)
     *
     * @var Word[]
     */
    protected $wordsStarted = [];

    /**
     * @param Column $col
     * @param Row $row
     */
    public function __construct(Column $col, Row $row) {
        $this->setColumn($col);
        $this->setRow($row);
    }

    /**
     * @param $line string column|row
     * @return Field Следующее поле
     */
    public function getNext($line)
    {
        return $this->getNeighbor($line, 'next');
    }

    /**
     * @param $line string ('column'|'row')
     * @param $line
     * @return Field Предыдущее поле
     */
    public function getPrev($line)
    {
        return $this->getNeighbor($line, 'prev');
    }

    /**
     * @param string $line column|row
     * @param string $direction prev|next
     * @return Field Предыдущее или следующее поле
     * @throws \Exception
     */
    protected function getNeighbor($line, $direction)
    {
        switch($line) {
            case 'column':
                $line = $this->getColumn();
                $currentIndex = $this->getRow()->getIndex();
                break;
            case 'row':
                $line = $this->getRow();
                $currentIndex = $this->getColumn()->getIndex();
                break;
            default:
                throw new \Exception('Не известное направление. (' . $line . ')');
        }

        switch($direction) {
            case 'prev':
                $index = $currentIndex - 1;
                break;
            case 'next':
                $index = $currentIndex + 1;
                break;
        }
        return $line->getByIndex($index);
    }

    /**
     * @return null|string
     */
    public function getChar() {
        return $this->char;
    }

    /**
     * @param string $char
     */
    public function setChar($char) {
        $this->char = (string) $char;
    }

    /**
     * @return Column
     */
    public function getColumn() {
        return $this->column;
    }

    /**
     * @param Column $col
     */
    public function setColumn(Column $col) {
        $this->column = $col;
    }

    /**
     * @return Row
     */
    public function getRow() {
        return $this->row;
    }

    /**
     * @param Row $row
     */
    public function setRow(Row $row) {
        $this->row = $row;
    }

    /**
     * @return bool
     */
    public function isBlock() {
        return $this->isBlock;
    }

    /**
     * @param bool $value
     */
    public function setBlock($value) {
        $this->isBlock = (bool) $value;
    }

    /**
     * @return Word[]
     */
    public function getWordsStarted()
    {
        return $this->wordsStarted;
    }

    /**
     * @param array $wordsStarted
     */
    public function addWordsStarted($wordsStarted)
    {
        $this->wordsStarted[] = $wordsStarted;
    }
}
