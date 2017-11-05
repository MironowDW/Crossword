<?php

namespace Crossword\Line;

use \Crossword\Field;
use \Crossword\Word;

/**
 * Линия кроссворда (Строка или колонка)
 */
abstract class Line
{

    /**
     * Тип линии. Колонка
     */
    const TYPE_COLUMN = 'column';

    /**
     * Тип линии. Строка
     */
    const TYPE_ROW = 'row';

    /**
     * Тип размещения. Справо
     */
    const PLACE_RIGHT = 'placeRight';

    /**
     * Тип размещения. Слево
     */
    const PLACE_LEFT = 'placeLeft';

    /**
     * Тип размещения. По центру
     */
    const PLACE_CENTER = 'placeCenter';

    /**
     * Тип размещения. В случайном месте
     */
    const PLACE_RANDOM = 'placeRandom';

    /**
     * @var string self::TYPE_* Текущий тип линии
     */
    protected $type = null;

    /**
     * @var array|Field[]
     */
    protected $fields = array();

    /**
     * @var string|null
     */
    protected $mask = '';

    /**
     * @var int
     */
    protected $index;

    /**
     * @param $index
     */
    public function __construct($index)
    {
        $this->setIndex($index);
    }

    /**
     * @return null|string Pattern текущей линии
     */
    public function getMask()
    {
        if(empty($this->mask)) {
            $nullCount = 0;
            foreach($this->getFields() as $field) {
                $char = $field->getChar();
                if(is_null($char)) {
                    $nullCount++;
                } else {
                    if($nullCount > 0) {
                        $this->mask .= '[a-zа-я]{1,' . $nullCount . '}';
                    }
                    $this->mask .= $char;
                }
            }
            if($nullCount > 0) {
                $this->mask .= '[a-zа-я]{1,' . $nullCount . '}';
            }
            if(!empty($this->mask)) {
                $this->mask = '!' . $this->mask . '!ui';
            }
        }
        return $this->mask;
    }

    /**
     * Размещение слова на линии
     *
     * @param \Crossword\Word $_word
     * @param bool $isFirstWord
     * @param string $place Тип размещения SELF::PLACE_*
     * @return bool Расположено слово или нет
     */
    public function position(Word $_word, $isFirstWord = false, $place = self::PLACE_RANDOM)
    {
        $word = $_word->getWord();
        $fields = $this->getFields();
        $wordLength = mb_strlen($word, 'UTF-8');
        $fieldsCount = count($fields);
        $type = $this->getType();

        // Разбиваем слово в массив
        $chars = array();
        for($i = 0; $wordLength > $i; $i++) {
            $chars[] = mb_substr($word, $i, 1, 'UTF-8');
        }

        // Находим все смещения (| | |с|л|о|в|о| Тут смещение будет равно 2)
        $maxOffsets = $fieldsCount - count($chars);
        $offsets = array();
        for($i = 1; $maxOffsets >= $i; $i++) {
            $offsets[] = $i;
        }

        // Сортируем смещения в зависимости от размещения
        if(empty($offsets)) {
            $offsets[] = 0;
        } elseif(count($offsets) > 1) {
            switch($place) {
                case self::PLACE_RANDOM:
                    shuffle($offsets);
                    break;
                case self::PLACE_RIGHT:
                    arsort($offsets);
                    break;
                case self::PLACE_LEFT:
                    asort($offsets);
                    break;
                case self::PLACE_CENTER:

                    break;
            }

        }

        // Пытаемся расположить слово при каждом смещение
        foreach($offsets as $offset) {
            $_fields = array_slice($fields, $offset);

            // Можно при таком смещение расположить слово или нет
            $check = true;
            // При размещение заденуто хотя бы одно поле с буквой
            $oneChar = false;

            // Массив вида array(0 => array('char' => ..., 'field' => ...))
            // В случае успешного расположения слова все поля из $storage будут заполнены буквами
            // В противном случае массив обнулится
            $storage = array();
            $i = 0;
            $isFirst = true;
            $isLast = false;
            foreach($_fields as $_field) {
                if(($i + 1) > $wordLength) {
                    continue;
                }
                if(($i + 1) == $wordLength) {
                    $isLast = true;
                }

                // Буква в текущем поле
                $char = $_field->getChar();
                // Буква, которую мы хотим положить в поле
                $newChar = $chars[$i];
                // Линия параллельная с линией слова
                $lineCurrent = ($type == self::TYPE_COLUMN) ? $_field->getColumn() : $_field->getRow();
                // Линия перпендикулярная линии слова
                $lineCross = ($type == self::TYPE_COLUMN) ? $_field->getRow() : $_field->getColumn();

                // Если поле заблокировано или буква не подходит, слово нельзя расположить
                if($_field->isBlock() || (!empty($char) && $char != $newChar)) {
                    $check = false;
                    break;
                }

                // Что бы разместить букву, соседние поля должны быть пустыми
                if(empty($char)) {
                    $lineNeighbors = $lineCurrent->getNeighbors();
                    foreach($lineNeighbors as $lineNeighbor) {
                        $field = $lineNeighbor->getByIndex($lineCross->getIndex());
                        if(!empty($field)) {
                            $neighborChar = $field->getChar();
                            if(!empty($neighborChar)) {
                                $check = false;
                                break;
                            }
                        }
                    }
                }

                // Если это первое или последнее поле, соседнее поле должно быть пустое
                if($isFirst || $isLast) {
                    $neighbor = $isFirst ? $_field->getPrev($type) : $_field->getNext($type);
                    if(!empty($neighbor)) {
                        $neighborChar = $neighbor->getChar();
                        if(!empty($neighborChar)) {
                            $check = false;
                            break;
                        }
                    }
                }

                // Если поле можно расположить
                if($check) {
                    if(!empty($char)) {
                        $oneChar = true;
                    }
                    $storage[] = array(
                        'field' => $_field,
                        'char' => $newChar
                    );
                }

                $isFirst = false;
                $i++;
            }

            // Если слово можно расположить и при этом заденута хотя бы одна буква (Или это первое слово)
            if($check && ($oneChar || $isFirstWord)) {
                $isFirst = true;
                $isLast = false;
                $count = 1;
                foreach($storage as $row) {
                    if($count == count($storage)) {
                        $isLast = true;
                    }

                    $field = $row['field'];
                    $char  = $row['char'];

                    // Блокируем поля по бокам, они больше не будут использоваться
                    if($isFirst || $isLast) {
                        $neighbor = $isFirst ? $field->getPrev($type) : $field->getNext($type);

                        if(!empty($neighbor)) {
                            $neighbor->setBlock(true);
                        }

                        if ($isFirst && $neighbor) {
                            $neighbor->addWordsStarted($_word);
                        }
                    }

                    // Устанавливаем букву для поля
                    if(is_null($field->getChar())) {
                        $field->setChar($char);
                    }

                    // Устанавливаем колонку или строку на которой расположено слово
                    // А так же поля или колонки которые затрагивают слово
                    if($type == self::TYPE_COLUMN) {
                        $_word->setBaseColumn($field->getColumn());
                        $_word->addRow($field->getRow());
                    } elseif($type == self::TYPE_ROW) {
                        $_word->setBaseRow($field->getRow());
                        $_word->addCol($field->getColumn());
                    }

                    $isFirst = false;
                    $count++;
                }
                // Теперь слово используется в кроссворде
                $_word->setIsUsed(true);

                return true;
            }
        }
        return false;
    }

    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     */
    public function resetMask()
    {
        $this->mask = '';
    }

    /**
     * @param $mask
     */
    public function setMask($mask)
    {
        $this->mask = (string) $mask;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param $index
     */
    public function setIndex($index)
    {
        $this->index = (int) $index;
    }

    /**
     * @return array|Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $index
     * @return bool
     */
    public function getByIndex($index) {
        $fields = $this->getFields();
        if(array_key_exists($index, $fields)) {
            return $fields[$index];
        }
        return false;
    }

    /**
     * Возвращает соседей
     *
     * @abstract
     */
    abstract public function getNeighbors();

    /**
     * Добавление поля в линию
     *
     * @abstract
     * @param Field $field
     */
    abstract public function addField(Field $field);

}