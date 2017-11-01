<?php

namespace Crossword;

use \Crossword\Generate\Generate;
use \Crossword\Collection\Word;
use \Crossword\Collection\Column;
use \Crossword\Collection\Row;
use \Crossword\Line\Column as LineCol;
use \Crossword\Line\Row as LineRow;

/**
 * Генерирование кроссворда из списка слов. 
 * Есть возможность генерировать кроссворд в рандомном порядке или на основе одного слова.
 * Библиотека написана так, что бы способы генерации можно было написать самому и легко добавить в код.
 * 
 * @author Mironov Dmitriy <MironovDW@bk.ru>
 */ 
class Crossword
{

    /**
     * @var int Количество колонок
     */
    protected $columnsCount;

    /**
     * @var int Количество строк
     */
    protected $rowsCount;

    /**
     * @var Column Коллекция колонок
     */
    protected $columns;

    /**
     * @var Row Коллекция строк
     */
    protected $rows;

    /**
     * @var array
     */
    protected $originWords;

    /**
     * @var Word Коллекция слов
     */
    protected $words;

    /**
     * @params int $colsCount Количество колонок
     * @params int $rowsCount Количество строк
     * @params array $words   Список слов
     */
    public function __construct($colsCount, $rowsCount, array $words)
    {
        $this->setColumnsCount($colsCount);
        $this->setRowsCount($rowsCount);
        $this->setOriginWords($words);

        $this->init();
    }

    /**
     * Инициализиция класса
     */
    protected function init()
    {
        $this->words = new Word($this->originWords);
        $this->generateFields();
    }

    public function clear()
    {
        $this->init();
    }

    /**
     * Автоматически генерирует кроссворд из списка слов
     * Тип генерации можно выбрать из класса CrosswordGenerate, там же можно посмотреть как написать свой тип.
     *
     * @param string $type Тип генерации (CrosswordGenerate::RANDOM, CrosswordGenerate::BASE_LINE, ...)
     * @param bool $needAllWords
     * @param int $maxGenerateAttempts Max count of crossword generation
     * @param int $maxWordPositionAttempts Max count of words positioning
     *
     * @return bool Сгенерирован кроссворд или нет
     */
    public function generate(
        $type = Generate::TYPE_RANDOM,
        $needAllWords = false,
        $maxGenerateAttempts = Generate::MAX_GENERATE_ATTEMPTS,
        $maxWordPositionAttempts = Generate::MAX_WORD_POSITION_ATTEMPTS
    ) {
        return Generate::factory($type, $this)->generate($needAllWords, $maxGenerateAttempts, $maxWordPositionAttempts);
    }

    /**
     * На основе количества колонок и строк генерирует необходимое количество колонок, строк и полей
     */
    protected function generateFields()
    {
        $columnsCount = $this->getColumnsCount();
        $rowsCount = $this->getRowsCount();

        $columns = new Column();
        $rows = new Row();

        $first = true;
        for($i = 1 ; $columnsCount >= $i ; $i++) {
            $col = new LineCol($i, $this);
            $columns->addCol($col);

            for($k = 1 ; $rowsCount >= $k ; $k++) {
                if($first) {
                    $row = new LineRow($k, $this);
                    $rows->addRow($row);
                }

                $_row = $rows->getByIndex($k);
                $field = new Field($col, $_row);

                $col->addField($field);
                $_row->addField($field);
            }

            $first = false;
        }

        $this->setRows($rows);
        $this->setColumns($columns);
    }

    /**
     * @return Word Коллекция слов
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @return Column Коллекция колонок
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @params Cols Коллекция колонок
     */
    public function setColumns(Column $columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return Row Коллекция строк
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @params Row Коллекция строк
     */
    public function setRows(Row $rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return int Количество колонок
     */
    public function getColumnsCount()
    {
        return $this->columnsCount;
    }

    /**
     * @params int Количество колонок
     */
    public function setColumnsCount($columnsCount)
    {
        $this->columnsCount = (int) $columnsCount;
    }

    /**
     * @return int Количество строк
     */
    public function getRowsCount()
    {
        return $this->rowsCount;
    }

    /**
     * @params int Количество строк
     */
    public function setRowsCount($rowsCount)
    {
        $this->rowsCount = (int) $rowsCount;
    }

    /**
     * @return array
     */
    public function getOriginWords()
    {
        return $this->originWords;
    }

    /**
     * @param array $originWords
     */
    public function setOriginWords($originWords)
    {
        $this->originWords = $originWords;
    }

    public function toArray()
    {
        $array = [];
        $index = 0;
        foreach ($this->getRows() as $row) {
            foreach ($row->getFields() as $field) {
                $array[$index][] = ($field->getChar() ? $field->getChar() : ' ');
            }

            $index++;
        }

        return $array;
    }

}