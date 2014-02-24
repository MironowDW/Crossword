<?php

namespace Crossword\Generate\BaseLine;

use \Crossword\Generate\Generate;
use \Crossword\Line\Line;
use \Crossword\Word;

/**
 * Генерация кроссворда на основе 1 слова
 */
abstract class BaseLine extends Generate
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

            $centerLine->position($word, true, Line::PLACE_LEFT);
            return true;
        }
        return false;
    }

    protected function positionWord(Word $word)
    {
        $line = $this->getBaseLine();

        if(!empty($line)) {
            $line->position($word, false);
        }
    }

}