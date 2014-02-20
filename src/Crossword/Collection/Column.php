<?php

namespace Crossword\Collection;

use \Crossword\Line\Column as LineCol;

/**
 * Коллекция солонок
 */
class Column extends Collection
{

    /**
     * @param LineCol $col
     */
    public function addCol(LineCol $col) {
        parent::add($col, $col->getIndex());
    }

    /**
     * @return array
     */
    public function getColumns() {
        return $this->items;
    }

}
