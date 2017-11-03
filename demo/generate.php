<?php

require_once './autoloader.php';

// List of words for crossword generation
$words = array(
    'keyboard' => [
        'number' => 1,
        'question' => 'Question 1',
    ],
    'leader' => [
        'number' => 2,
        'question' => 'Question 2',
    ],
    'apple' => [
        'number' => 3,
        'question' => 'Question 3',
    ],
);

// Create new crossword
$crossword = new \Crossword\Crossword(10, 10, $words);
$crossword->generate(\Crossword\Generate\Generate::TYPE_BASE_LINE_COLUMN, true);

return $crossword;