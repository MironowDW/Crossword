<?php

$userCrossword = $_POST['crossword'];

// Get last generated crossword
$originalCrossword = file_get_contents(__DIR__ . '/crossword.json');
if (!$originalCrossword) {
    throw new \Exception('Crossword not found');
}

$originalCrossword = json_decode($originalCrossword, true);

echo json_encode(['is_success' => $userCrossword == $originalCrossword]);