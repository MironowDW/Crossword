<?php

require_once './autoloader.php';

// List of words for crossword generation
$words = array(
    'leader' => [
        'number' => 1,
        'question' => 'Input "leader"',
    ],
    'apple' => [
        'number' => 2,
        'question' => 'Input "apple"',
    ],
);

// Create new crossword
$crossword = new \Crossword\Crossword(10, 10, $words);
$crossword->generate(\Crossword\Generate\Generate::TYPE_BASE_LINE_COLUMN, true);

// Save for check
file_put_contents(__DIR__ . '/crossword.json', json_encode($crossword->toArray(), JSON_PRETTY_PRINT));

return $crossword;