<?php
use Synthesizer\Generator\Arranger\Track;
use Synthesizer\Generator\Arranger\Clip;
use Synthesizer\Generator\Arranger\SequentialClip;
use Synthesizer\Generator\Instrument\Bell;
use Synthesizer\Generator\Instrument\Retro;

/** @var \Synthesizer\Time\Clock $clock */

$speed = 13;

$melodyTrack = new Track(new Bell($clock), $clock);
$melodyTrack->addClip(0, new SequentialClip([
    ['E4', 40 * $speed],
    ['B3', 20 * $speed],
    ['C4', 20 * $speed],
    ['D4', 40 * $speed],
    ['C4', 20 * $speed],
    ['B3', 20 * $speed],
    ['A3', 40 * $speed],
    ['A3', 20 * $speed],
    ['C4', 20 * $speed],
    ['E4', 40 * $speed],
    ['D4', 20 * $speed],
    ['C4', 20 * $speed],
    ['B3', 60 * $speed],
    ['C4', 20 * $speed],
    ['D4', 40 * $speed],
    ['E4', 40 * $speed],
    ['C4', 40 * $speed],
    ['A3', 40 * $speed],
    ['A3', 60 * $speed],
]));

$bassTrack = new Track(new Retro($clock), $clock, 0.5);
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
