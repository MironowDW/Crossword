<?php

namespace Crossword\Collection;

/**
 * Коллекция слов
 */
class Word extends Collection
{

    /**
     * @param array $words
     */
    public function __construct(array $words = array())
    {
        foreach($words as $key => $word) {
            $params = [];

            if (is_array($word)) {
                $params = $word;
                $word = $key;
            }

            parent::add(new \Crossword\Word($word, $params));
        }
    }

    /**
     * Возвращает случайное слово по маске
     *
     * @param string $mask Pattern
     * @param bool $most Наибольшее слово
     * @return bool|\Crossword\Word
     */
    public function getByMask($mask, $most = false) {
        $words = new Word();
        foreach($this as $word) {
            if($word->inMask($mask)) {
                $words->add($word);
            }
        }
        if($most) {
            $most = null;
            foreach($words as $word) {
                if(empty($most)) {
                    $most = $word;
                } elseif(mb_strlen($word->getWord(), 'UTF-8') > mb_strlen($most->getWord(), 'UTF-8')) {
                    $most = $word;
                }
            }
            return $most;
        }
        return $words->getRandom();
    }

    /**
     * @return Word Коллекция не использованных слов
     */
    public function notUsed()
    {
        $words = new Word();
        foreach($this->getwords() as $word) {
            if(!$word->isUsed()) {
                $words->add($word);
            }
        }
        return $words;
    }

    /**
     * @return bool|\Crossword\Word Случайное слово из коллекции
     */
    public function getRandom() {
        $words = $this->getWords();
        if(!empty($words)) {
            $randKey = array_rand($words);
            return $words[$randKey];
        }
        return false;
    }

    /**
     * @return array
     */
    public function getWords() {
        return $this->items;
    }

}
