<?php

namespace CrosswordTest;

class WordTest extends \PHPUnit_Framework_TestCase
{

    /** @var \Crossword\Word */
    private $word;

    public function setUp()
    {
        $this->word = $this->getMock('\Crossword\Word', null, array(), '', false);
    }

    /**
     * @expectedException \Crossword\Exception
     * @dataProvider failWordsProvider
     */
    public function testFailValidate($word)
    {
        $this->word->validate($word);
    }

    public function testValidate()
    {
        $this->word->validate('test');
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