<?php
// E4 D4
// E4 D4
// D4 D4 D4 C#4
// C#4 C#4 C#4 D4
// D4 C#4 D4
use Synthesizer\Input\Producer\Clip\SequentialClip;

/** @var int $speed */


$partOne = [
    [['S', 6 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['E4', 4 * $speed],],
    [['F#3', 6 * $speed], ['B3', 6 * $speed], ['D4', 6 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['E4', 4 * $speed],],
    [['F#3', 6 * $speed], ['B3', 6 * $speed], ['D4', 6 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['D4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['D4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['D4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['C#4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['C#4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['C#4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['C#4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 6 * $speed], ['B3', 6 * $speed], ['D4', 6 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 6 * $speed], ['B3', 6 * $speed], ['D4', 6 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 4 * $speed], ['B3', 4 * $speed], ['C#4', 4 * $speed],],
    [['S', 1 * $speed]],
    [['F#3', 6 * $speed], ['B3', 6 * $speed], ['D4', 6 * $speed],],
];

return new SequentialClip(array_merge_recursive(
    $partOne, $partOne, $partOne, $partOne,
));
