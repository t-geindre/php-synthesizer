<?php
use Synthesizer\Generator\Arranger\Track;
use Synthesizer\Generator\Arranger\Clip;
use Synthesizer\Generator\Arranger\SequentialClip;
use Synthesizer\Generator\Instrument\Bell;
use Synthesizer\Generator\Instrument\Organ;

/** @var \Synthesizer\Time\Clock $clock */

$speed = 13;

$melodyTrack = new Track(new Bell($clock), $clock);
$melodyTrack->addClip(0, new SequentialClip([
    ['E5', 40 * $speed],
    ['B4', 20 * $speed],
    ['C5', 20 * $speed],
    ['D5', 40 * $speed],
    ['C5', 20 * $speed],
    ['B4', 20 * $speed],
    ['A4', 40 * $speed],
    ['A4', 20 * $speed],
    ['C5', 20 * $speed],
    ['E5', 40 * $speed],
    ['D5', 20 * $speed],
    ['C5', 20 * $speed],
    ['B4', 60 * $speed],
    ['C5', 20 * $speed],
    ['D5', 40 * $speed],
    ['E5', 40 * $speed],
    ['C5', 40 * $speed],
    ['A4', 40 * $speed],
    ['A4', 60 * $speed],
]));

$bassTrack = new Track(new Organ($clock), $clock, 0.5);
$bassTrack->addClip(0, new Clip([
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
