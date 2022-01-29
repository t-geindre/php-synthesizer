<?php

use Synthesizer\Generator\Instrument\PolySynth;
use Synthesizer\Generator\Instrument\Kick;
use Synthesizer\Generator\Instrument\MonoBass;
use Synthesizer\Input\Producer\Clip\SequentialClip;
use Synthesizer\Input\Track;

/** @var \Synthesizer\Time\Clock\Clock $clock*/
$s = 50; // Speed
$melody = new SequentialClip($basePart = [
    [['S', 6 * $s]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['E4', 4 * $s],],
    [['S', 1 * $s]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['E4', 4 * $s],],

    [['S', 1 * $s]],
    [['E4', 2 * $s],],

    [['F#3', 6 * $s], ['B3', 6 * $s], ['D4', 6 * $s],],
    [['S', 2 * $s]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['D4', 4 * $s],],
    [['S', 1* $s]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['D4', 4 * $s],],

    [['S', 1* $s]],
    [['D4', 2 * $s],],

    [['F#3', 6 * $s], ['B3', 6 * $s], ['C#4', 6 * $s],],
    [['S', 2 * $s]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['C#4', 4 * $s],],
    [['S', 1 * $s]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['C#4', 4 * $s],],

    [['S', 1 * $s]],
    [['C#4', 2 * $s],],

    [['F#3', 6 * $s], ['B3', 6 * $s], ['D4', 6 * $s],],
    [['S', 2 * $s]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['D4', 4 * $s],],
    [['S', (int) (1 * $s)]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['C#4', 4 * $s],],
    [['S', (int) (1 * $s)]],
    [['F#3', 4 * $s], ['B3', 4 * $s], ['D4', 4 * $s],],
]);

$upPart = $basePart;
$upPart[6][2][0] = 'F#4';
$upPart[8][2][0] = 'F#4';
$upPart[10][2][0] = 'F#4';
$upPart[12][0][0] = 'F#4';


$melody->append($basePart); // 4800
$melody->append($upPart);
$melody->append($upPart);


$kicks = new SequentialClip(array_merge(
    array_fill(0, 64, [['G1', 10 * $s]])
));


$acc = new SequentialClip([
    [['B2', 10 * $s]],
    [['B2', 10 * $s]],
    [['B2', 10 * $s]],
    [['B2', 10 * $s]],
    [['F#2', 10 * $s]],
    [['F#2', 10 * $s]],
    [['G2', 10 * $s]],
    [['G2', 10 * $s]],
]);

$melodyTrack = Track::withBasicHandler(new PolySynth($clock), $clock, .5);
$melodyTrack->append($melody);
$melodyTrack->append($melody);
$melodyTrack->append($melody);
$melodyTrack->append($melody);

$accTrack = Track::withBasicHandler(new MonoBass($clock), $clock);
//$accTrack->addAT($acc, 2 * $s);
//$accTrack->append($acc);

$kicksTrack = Track::withBasicHandler(new Kick($clock), $clock, 1);
$kicksTrack->addAt($kicks, 2 * $s);


return [$melodyTrack, $kicksTrack];
