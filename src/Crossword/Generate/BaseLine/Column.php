<?php

namespace Crossword\Generate\BaseLine;

/**
 * Генерация кроссворда на основе одного слова по вертикали
 */
class Column extends BaseLine
{

    protected function getCenterLine()
    {
        return $this->getCenterCol();
    }

    protected function getBaseLine()
    {
        return $this->firstWord->getRows()->getRandom();
    }

}