<?php

use Synthesizer\Input\Producer\Clip\SequentialClip;

/** @var int $speed */

$accompaniment = [
    [['B2', 10 * $speed]],
    [['B2', 10 * $speed]],
    [['B2', 10 * $speed]],
    [['B2', 10 * $speed]],
    [['F#2', 10 * $speed]],
    [['F#2', 10 * $speed]],
    [['G2', 10 * $speed]],
    [['G2', 10 * $speed]],
];

return new SequentialClip(array_merge(
    $accompaniment, $accompaniment, $accompaniment, $accompaniment
));








