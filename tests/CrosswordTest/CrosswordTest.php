<?php

namespace CrosswordTest;

class CrosswordTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function mustGeneratedRandomCrossword()
    {
        $words = ['of', 'on'];

        $crossword = new \Crossword\Crossword(2, 2, $words);
        $isGenerated = $crossword->generate(\Crossword\Generate\Generate::TYPE_RANDOM);

        $this->assertTrue($isGenerated, 'Random crossword not generated');

        $this->assertEquals(2, $crossword->getRowsCount(), 'Wrong rows count');
        $this->assertEquals(2, $crossword->getColumnsCount(), 'Wrong columns count');

        // All variants for 2*2 random crossword
        $variants = [
            [
                ['o', 'n'],
                ['f', ' '],
            ],
            [
                ['o', 'f'],
                ['n', ' '],
            ],
            [
                ['n', 'o'],
                [' ', 'f'],
            ],
            [
                [' ', 'n'],
                ['f', 'o'],
            ],
            [
                [' ', 'f'],
                ['n', 'o'],
            ],
            [
                ['f', ' '],
                ['o', 'n'],
            ],
        ];

        $this->assertTrue(
            in_array($crossword->toArray(), $variants),
            'Wrong crossword generated: ' . var_export($crossword->toArray(), true)
        );
    }

    /**
     * @test
     */
    public function mustGeneratedBaselineColumnCrossword()
    {
        $words = ['off', 'on'];

        $crossword = new \Crossword\Crossword(2, 3, $words);
        $isGenerated = $crossword->generate(\Crossword\Generate\Generate::TYPE_BASE_LINE_COLUMN);

        $this->assertTrue($isGenerated, 'Baseline column crossword not generated');

        $this->assertEquals(3, $crossword->getRowsCount(), 'Wrong rows count');
        $this->assertEquals(2, $crossword->getColumnsCount(), 'Wrong columns count');

        // There is one variant for this crossword
        $expected = [
            ['o', 'n'],
            ['f', ' '],
            ['f', ' '],
        ];

        $this->assertEquals(
            $expected,
            $crossword->toArray(),
            'Wrong crossword generated: ' . var_export($crossword->toArray(), true)
        );
    }

    /**
     * @test
     */
    public function mustGeneratedBaselineRowCrossword()
    {
        $words = ['off', 'on'];

        $crossword = new \Crossword\Crossword(3, 2, $words);
        $isGenerated = $crossword->generate(\Crossword\Generate\Generate::TYPE_BASE_LINE_ROW);

        $this->assertTrue($isGenerated, 'Baseline row crossword not generated');

        $this->assertEquals(2, $crossword->getRowsCount(), 'Wrong rows count');
        $this->assertEquals(3, $crossword->getColumnsCount(), 'Wrong columns count');

        // There is one variant for this crossword
        $expected = [
            ['o', 'f', 'f'],
            ['n', ' ', ' '],
        ];

        $this->assertEquals(
            $expected,
            $crossword->toArray(),
            'Wrong crossword generated: ' . var_export($crossword->toArray(), true)
        );
    }

    /**
     * @test
     */
    public function mustGeneratedRandomCrosswordByMiddleWords()
    {
        $words = [
            'google',
            'facebook',
            'twitter',
            'internet',
            'mark',
            'instagram',
            'intel',
            'global',
            'linux',
        ];

        $crossword = new \Crossword\Crossword(20, 20, $words);
        $isGenerated = $crossword->generate(\Crossword\Generate\Generate::TYPE_RANDOM, true);

        $this->assertTrue($isGenerated, 'Random with middle words not generated');
    }
}
