<?php

use Synthesizer\Generator\Instrument\Bell;
use Synthesizer\Generator\Instrument\Organ;
use Synthesizer\Input\Producer\Clip\Clip;
use Synthesizer\Input\Producer\Clip\SequentialClip;
use Synthesizer\Input\Track;

$speed = 13;

$melodyTrack = Track::withBasicHandler(new Bell(), .8);
$melodyTrack->append(new SequentialClip([
    [['E5', 40 * $speed]],
    [['B4', 20 * $speed]],
    [['C5', 20 * $speed]],
    [['D5', 40 * $speed]],
    [['C5', 20 * $speed]],
    [['B4', 20 * $speed]],
    [['A4', 40 * $speed]],
    [['A4', 20 * $speed]],
    [['C5', 20 * $speed]],
    [['E5', 40 * $speed]],
    [['D5', 20 * $speed]],
    [['C5', 20 * $speed]],
    [['B4', 60 * $speed]],
    [['C5', 20 * $speed]],
    [['D5', 40 * $speed]],
    [['E5', 40 * $speed]],
    [['C5', 40 * $speed]],
    [['A4', 40 * $speed]],
    [['A4', 60 * $speed]],
]));

$bassTrack = Track::withBasicHandler(new Organ(), 0.5);
$bassTrack->append(new Clip([
    ['B2', 0 * $speed, 40 * $speed],
    ['G#2', 0 * $speed, 40 * $speed],
    ['E2', 40 * $speed, 40 * $speed],
    ['B2', 80 * $speed, 40 * $speed],
    ['G#2', 80 * $speed, 40 * $speed],
    ['E2', 120 * $speed, 40 * $speed],
    ['A2', 160 * $speed, 40 * $speed],
    ['C3', 160 * $speed, 40 * $speed],
    ['E2', 200 * $speed, 40 * $speed],
    ['A2', 240 * $speed, 40 * $speed],
    ['C3', 240 * $speed, 40 * $speed],
    ['E2', 280 * $speed, 40 * $speed],
    ['B2', 320 * $speed, 40 * $speed],
    ['G#2', 320 * $speed, 40 * $speed],
    ['E2', 360 * $speed, 40 * $speed],
    ['B2', 400 * $speed, 40 * $speed],
    ['G#2', 400 * $speed, 40 * $speed],
    ['E2', 440 * $speed, 40 * $speed],
    ['A2', 480 * $speed, 40 * $speed],
    ['C3', 480 * $speed, 40 * $speed],
    ['E2', 520 * $speed, 40 * $speed],
    ['A2', 560 * $speed, 60 * $speed],
    ['C3', 560 * $speed, 60 * $speed],
]));

return [$melodyTrack, $bassTrack];
