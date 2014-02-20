<?php

namespace Crossword\Line;

use \Crossword\Field;

/**
 * Строка кроссворда
 */
class Row extends Line
{

    /**
     * @var string Тип линии. Строка
     */
    protected $type = self::TYPE_ROW;

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {
        $this->fields[$field->getColumn()->getIndex()] = $field;
    }

    /**
     * @return array
     */
    public function getNeighbors()
    {
        $fields = $this->getFields();
        $row = $fields[1]->getColumn();

        $neighbor = array();
        $field = $row->getByIndex($this->getIndex() + 1);
        if(!empty($field)) {
            $neighbor[] = $field->getRow();
        }
        $field = $row->getByIndex($this->getIndex() - 1);
        if(!empty($field)) {
            $neighbor[] = $field->getRow();
        }
        return $neighbor;
    }

}
