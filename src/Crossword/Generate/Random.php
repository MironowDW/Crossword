<?php

namespace Crossword\Generate;

/**
 * Генерация кроссворда в случайном порядке
 */
class Random extends \Crossword\Generate\Generate
{

    /**
     * @var \Crossword\Word
     */
    protected $prevWord;

    protected $currentLineType;

    protected function positionFirstWord()
    {
        $centerRow = $this->getCenterRow();
        $mask = $centerRow->getMask();

        $word = $this->crossword->getWords()->getByMask($mask);

        if(!empty($word)) {
            $this->prevWord = $word;
            $this->currentLineType = \Crossword\Line\Line::TYPE_COLUMN;

            $centerRow->position($word, true);
            return true;
        }
        return false;
    }

    protected function positionWord(\Crossword\Word $word)
    {
        if($this->currentLineType == \Crossword\Line\Line::TYPE_ROW) {
            $line = $this->prevWord->getRows()->getRandom();
            $this->currentLineType = \Crossword\Line\Line::TYPE_COLUMN;
        } else {
            $line = $this->prevWord->getColumns()->getRandom();
            $this->currentLineType = \Crossword\Line\Line::TYPE_ROW;
        }

        if(!empty($line)) {
            $isPosition = $line->position($word, false);
            if($isPosition) {
                $this->prevWord = $word;
            }
        }
    }

}