<?php

use Synthesizer\Generator\Instrument\PolySynth;
use Synthesizer\Input\Producer\Clip\SequentialClip;
use Synthesizer\Input\Track;

/** @var \Synthesizer\Time\Clock $clock*/
$s = 60; // Speed
$melody = new SequentialClip([
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['E4', 4 * $s],
    ],
    [['S', 1 * $s]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['E4', 4 * $s],
    ],
    [['S', (int)(2.5 * $s)]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['D4', 4 * $s],
    ],
    [['S', 2 * $s]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['D4', 4 * $s],
    ],
    [['S', 1* $s]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['D4', 4 * $s],
    ],
    [['S', (int)(2.5 * $s)]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['C#4', 4 * $s],
    ],
    [['S', 2 * $s]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['C#4', 4 * $s],
    ],
    [['S', 1 * $s]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['C#4', 4 * $s],
    ],
    [['S', (int)(2.5 * $s)]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['D4', 4 * $s],
    ],
    [['S', 2 * $s]],
        [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['D4', 4 * $s],
    ],
    [['S', (int) (.5 * $s)]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['C#4', 4 * $s],
    ],
    [['S', (int) (.5 * $s)]],
    [
        ['F#3', 4 * $s],
        ['B3', 4 * $s],
        ['D4', 4 * $s],
    ],
]);

$melodyTrack = Track::withBasicHandler(new PolySynth($clock), $clock);
$melodyTrack->append($melody);

return [$melodyTrack];
