<?php

use Synthesizer\Input\Producer\Clip\SequentialClip;

/** @var int $speed */


$partOne = [
    [['S', 6 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['E4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['E4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['E4', 2 * $speed],],
    [['F#3', 6 * $speed], ['B3', 6 * $speed], ['D4', 6 * $speed],],
    [['S', 2 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['D4', 4 * $speed],],
    [['S', 1* $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['D4', 4 * $speed],],
    [['S', 1* $speed]],
    [['D4', 2 * $speed],],
    [['F#3', 6 * $speed], ['B3', 6 * $speed], ['C#4', 6 * $speed],],
    [['S', 2 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['C#4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['C#4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['C#4', 2 * $speed],],
    [['F#3', 6 * $speed], ['B3', 6 * $speed], ['D4', 6 * $speed],],
    [['S', 2 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['D4', 4 * $speed],],
    [['S', (int) (1 * $speed)]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['C#4', 4 * $speed],],
    [['S', (int) (1 * $speed)]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['D4', 4 * $speed],],
];

$partTwo = $partOne;
$left = 4;
foreach ($partTwo as &$line) {
    foreach ($line as [&$note]) {
        if ($note == 'D4') {
            $note = 'F#4';
            $left--;
        }
    }
    if ($left == 0) {
        break;
    }
}

return new SequentialClip(array_merge_recursive(
    $partOne, $partOne, $partTwo, $partTwo
));
