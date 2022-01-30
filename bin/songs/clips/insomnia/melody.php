<?php

use Synthesizer\Input\Producer\Clip\SequentialClip;

/** @var int $speed */

return new SequentialClip($basePart = [
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
]);
