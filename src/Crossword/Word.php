<?php

namespace Crossword;

use \Crossword\Collection\Column;
use \Crossword\Collection\Row;
use \Crossword\Line\Row as LineRow;
use \Crossword\Line\Column as LineCol;

/**
 * Слово кроссворда
 */
class Word
{

    /**
     * @var string
     */
    protected $word;

    /**
     * @var Row|null
     */
    protected $rows = null;

    /**
     * @var Column|null
     */
    protected $columns = null;

    /**
     * @var null
     */
    protected $baseColumn = null;

    /**
     * @var null
     */
    protected $baseRow = null;

    /**
     * @var bool
     */
    protected $isUsed;

    /**
     * @param $word
     */
    public function __construct($word)
    {
        $this->setWord($word);

        $this->rows = new Row();
        $this->columns = new Column();

        $this->validate($word);
    }

    /**
     * @param LineCol $col
     */
    public function addCol(LineCol $col)
    {
        $this->columns->add($col);
    }

    /**
     * @return Column|null
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param LineRow $row
     */
    public function addRow(LineRow $row)
    {
        $this->rows->add($row);
    }

    /**
     * @return Row|null
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param LineCol $col
     */
    public function setBaseColumn(LineCol $col)
    {
        $this->baseColumn = $col;
    }

    /**
     * @return LineCol
     */
    public function getBaseColumn()
    {
        return $this->baseColumn;
    }

    /**
     * @param LineRow $col
     */
    public function setBaseRow(LineRow $col)
    {
        $this->baseRow = $col;
    }

    /**
     * @return LineRow
     */
    public function getBaseRow()
    {
        return $this->baseRow;
    }

    /**
     * @param $mask
     * @return int
     */
    public function inMask($mask)
    {
        return preg_match($mask, $this->getWord());
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param $word
     */
    public function setWord($word)
    {
        $this->word = (string) trim(mb_strtolower($word, 'UTF-8'));
    }

    /**
     * @return bool
     */
    public function isUsed()
    {
        return $this->isUsed;
    }

    /**
     * @param $isUsed
     */
    public function setIsUsed($isUsed)
    {
        $this->isUsed = (bool) $isUsed;
    }

    /**
     * Валидация слова
     *
     * @throws \Exception
     */
    public function validate($word)
    {
        if(empty($word)) {
            throw new Exception('Слово не может быть пустым.');
        }

        if(!preg_match('/^[a-zа-я]+$/ui', $word)) {
            throw new Exception('Слово должно состоять из букв Русского и Английского алфавита. (' . $word . ')');
        }
    }

}
