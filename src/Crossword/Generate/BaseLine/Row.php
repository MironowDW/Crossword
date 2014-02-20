<?php

namespace Crossword\Generate\BaseLine;

/**
 * Генерация кроссворда на основе одного слова по горизонтали
 */
class Row extends BaseLine
{

    protected function getCenterLine()
    {
        return $this->getCenterRow();
    }

    protected function getBaseLine()
    {
        return $this->firstWord->getColumns()->getRandom();
    }

}