<?php
use Synthesizer\Generator\Arranger\Track;
use Synthesizer\Generator\Arranger\SequentialClip;
use Synthesizer\Generator\Instrument\Retro;
use Synthesizer\Generator\Instrument\Bell;

/** @var \Synthesizer\Time\Clock $clock*/

$partition = [
    ['C4', 300],
    ['S', 50],
    ['D4', 300],
    ['S', 100],
    ['E4', 300],
    ['S', 100],
    ['F4', 300],
    ['S', 100],
    ['G4', 300],
    ['S', 100],
    ['A4', 300],
    ['S', 100],
    ['B4', 300],
    ['S', 100],
    ['C5', 300],
    ['S', 100],
    ['B4', 300],
    ['S', 100],
    ['A4', 300],
    ['S', 100],
    ['G4', 300],
    ['S', 100],
    ['F4', 300],
    ['S', 100],
    ['E4', 300],
    ['S', 100],
    ['D4', 300],
    ['S', 100],
    ['C4', 300],
];
$partitionLength = array_sum(array_column($partition, 1));

$tracks = [];

$track = new Track(new Retro($clock), $clock);
$track->addClip(0, new SequentialClip($partition));
$tracks[] = $track;

$track = new Track(new Bell($clock), $clock);
$track->addClip($partitionLength, new SequentialClip($partition));
$tracks[] = $track;

return $tracks;
