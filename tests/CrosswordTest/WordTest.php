<?php

namespace CrosswordTest;

class WordTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @expectedException \Crossword\Exception
     * @dataProvider failWordsProvider
     */
    public function mustThrowExceptionOnFailWord($word)
    {
        new \Crossword\Word($word);
    }

    /**
     * @test
     */
    public function noThrowExceptionOnCorrectWord()
    {
        new \Crossword\Word('test');
    }

    public function failWordsProvider()
    {
        return array(
            array('ddf fdg'),
            array(''),
            array('!!@23'),
        );
    }

}