<?php

require_once './autoloader.php';

// Список слов для генерации кроссворда
$words = array(
    'Кадр',
    'Дом',
    'Окно',
    'Монитор',
    'Слово',
    'Кружка',
    'Сосед',
    'Стул',
    'Папка',
    'Труба',
    'Город',
    'Дорога',
    'Клавиатура',
    'Земля',
    'Ручка',
);

// Создаем новый кроссворд 15*15
$crossword = new \Crossword\Crossword(15, 15, $words);
$crossword->generate(\Crossword\Generate\Generate::TYPE_BASE_LINE_COLUMN);

return $crossword;