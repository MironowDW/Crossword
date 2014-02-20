<?php

namespace Crossword\Collection;

use \Crossword\Line\Row as LineRow;

/**
 * Коллекция строк
 */
class Row extends Collection
{

    /**
     * @param LineRow $rol
     */
    public function addRow(LineRow $rol) {
        parent::add($rol, $rol->getIndex());
    }

    /**
     * @return array
     */
    public function getRows() {
        return $this->items;
    }

}
