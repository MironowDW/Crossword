Crossword
=========

Php crossword generator

Column base crossword
=========
```php
$words = ['hello', 'on', 'hi'];

$crossword = new \Crossword\Crossword(2, 5, $words);
$isGenerated = $crossword->generate(\Crossword\Generate\Generate::TYPE_BASE_LINE_COLUMN);

print_r($crossword->toArray());

// [
//   ['h', 'i'],
//   ['e', ' '],
//   ['l', ' '],
//   ['l', ' '],
//   ['o', 'n'],
// ]
```

Row base crossword
=========
```php
$words = ['hello', 'on', 'hi'];

$crossword = new \Crossword\Crossword(5, 2, $words);
$isGenerated = $crossword->generate(\Crossword\Generate\Generate::TYPE_BASE_LINE_ROW);

print_r($crossword->toArray());

// [
//   ['h', 'e', 'l', 'l', 'o'],
//   ['i', ' ', ' ', ' ', 'n'],
// ]
```

Random crossword
=========
```php
$words = ['ubuntu', 'bower', 'seed', 'need'];

$crossword = new \Crossword\Crossword(9, 9, $words);
$isGenerated = $crossword->generate(\Crossword\Generate\Generate::TYPE_RANDOM);

print_r($crossword->toArray());

// [
//   [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
//   [' ', ' ', 'u', 'b', 'u', 'n', 't', 'u', ' '],
//   [' ', ' ', ' ', 'o', ' ', 'e', ' ', ' ', ' '],
//   [' ', ' ', ' ', 'w', ' ', 'e', ' ', ' ', ' '],
//   [' ', ' ', 's', 'e', 'e', 'd', ' ', ' ', ' '],
//   [' ', ' ', ' ', 'r', ' ', ' ', ' ', ' ', ' '],
//   [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
//   [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
//   [' ', ' ', ' ', ' ', '', ' ', ' ', ' ', ' '],
// ]
```
