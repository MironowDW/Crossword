<?php

namespace Crossword\Generate\BaseLine;

/**
 * Генерация кроссворда на основе 1 слова
 */
abstract class BaseLine extends \Crossword\Generate\Generate
{

    /**
     * @var \Crossword\Word
     */
    protected $firstWord;

    /**
     * @return \Crossword\Line\Line
     */
    abstract protected function getCenterLine();

    /**
     * @return \Crossword\Line\Line
     */
    abstract protected function getBaseLine();

    protected function positionFirstWord()
    {
        $centerLine = $this->getCenterLine();
        $mask = $centerLine->getMask();

        $word = $this->crossword->getWords()->getByMask($mask, true);

        if(!empty($word)) {
            $this->firstWord = $word;

            $centerLine->position($word, true, \Crossword\Line\Line::PLACE_LEFT);
            return true;
        }
        return false;
    }

    protected function positionWord(\Crossword\Word $word)
    {
        $line = $this->getBaseLine();

        if(!empty($line)) {
            $line->position($word, false);
        }
    }

}