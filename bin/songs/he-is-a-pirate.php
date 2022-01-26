<?php

use Synthesizer\Input\Producer\Clip\Clip;
use Synthesizer\Input\Producer\Clip\SequentialClip;
use Synthesizer\Input\Track;
use Synthesizer\Generator\Instrument\Kick;
use Synthesizer\Generator\Instrument\PolySynth;
use Synthesizer\Generator\Instrument\MonoBass;

/** @var \Synthesizer\Time\Clock $clock*/
$s = 80; // Speed
$melody = new SequentialClip([
    // P1
    [['A3', 2 * $s]],
    [['C4', 2 * $s]],
    [['D4', 4 * $s], ['F4', 4 * $s]],
    [['D4', 4 * $s], ['F4', 4 * $s]],
    [['D4', 2 * $s]],
    [['E4', 2 * $s]],
    [['F4', 4 * $s], ['D4', 4 * $s]],
    [['F4', 4 * $s], ['D4', 4 * $s]],
    [['F4', 2 * $s]],
    [['G4', 2 * $s]],
    [['E4', 4 * $s], ['C4', 4 * $s]],
    [['E4', 4 * $s], ['C4', 4 * $s]],
    [['D4', 2 * $s]],
    [['C4', 2 * $s]],
    // P2
    [['D4', 8 * $s], ['F4', 8 * $s]],
    [['A3', 2 * $s]],
    [['C4', 2 * $s]],
    [['D4', 4 * $s], ['F4', 4 * $s]],
    [['D4', 4 * $s], ['F4', 4 * $s]],
    [['D4', 2 * $s]],
    [['E4', 2 * $s]],
    [['F4', 4 * $s], ['D4', 4 * $s]],
    [['F4', 4 * $s], ['D4', 4 * $s]],
    [['F4', 2 * $s]],
    [['G4', 2 * $s]],
    [['E4', 4 * $s], ['C4', 4 * $s]],
    [['E4', 4 * $s], ['C4', 4 * $s]],
    [['D4', 2 * $s]],
    [['C4', 2 * $s]],
    [['D4', 8 * $s], ['A3', 8 * $s]],
    // P3
    [['A3', 2 * $s]],
    [['C4',  2 * $s]],
    [['D4', 4 * $s], ['F4', 4 * $s]],
    [['D4', 4 * $s], ['F4', 4 * $s]],
    [['D4', 2 * $s]],
    [['F4', 2 * $s]],
    [['G4', 4 * $s], ['E4', 4 * $s]],
    [['G4', 4 * $s], ['E4', 4 * $s]],
    [['G4', 2 * $s]],
    [['A4', 2 * $s]],
    [['A#4', 4 * $s], ['D4', 4 * $s]],
    [['A#4', 4 * $s], ['D4', 4 * $s]],
    [['A4', 2 * $s]],
    [['G4', 2 * $s]],
    [['A4', 2 * $s]],
    [['D4', 6 * $s], ['A3', 6 * $s]],
    [['D4', 2 * $s]],
    [['E4', 2 * $s]],
    [['F4', 4 * $s]],
    [['F4', 4 * $s]],
    [['G4', 4 * $s]],
    [['A4', 2 * $s]],
    [['D4', 6 * $s], ['A3', 6 * $s]],
    [['D4', 2 * $s]],
    [['F4', 2 * $s]],
    [['E4', 4 * $s], ['C#4', 4 * $s]],
    [['E4', 4 * $s], ['C#4', 4 * $s]],
    [['F4', 2 * $s]],
    [['D4', 2 * $s]],
    [['E4', 8 * $s], ['C#4', 8 * $s]]
]);

$melodyOct = new Clip(array_map(
    function (array $line) {
        /** @var string $note */
        [$note, $at, $duration] = $line;
        return [preg_replace_callback(
            '/([A-Z#]+)([0-9]{1,})/',
            fn($parts) => $parts[1] . ((int)$parts[2] + 1),
            $note
        ), $at, $duration];
    },
    $melody->getPartition()
));

$accompaniment = new SequentialClip([
    [['S', 4 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['F3', 6 * $s], ['D3', 6 * $s]],
    [['F3', 6 * $s], ['D3', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['C3', 6 * $s], ['F2', 6 * $s]],
    [['C3', 6 * $s], ['F2', 6 * $s]],
    [['G3', 6 * $s], ['C3', 6 * $s]],
    [['G3', 6 * $s], ['C3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['G3', 6 * $s], ['A#2', 6 * $s]],
    [['G3', 6 * $s], ['A#2', 6 * $s]],
    [['D3', 6 * $s], ['G2', 6 * $s]],
    [['D3', 6 * $s], ['G2', 6 * $s]],
    [['D3', 6 * $s], ['F2', 6 * $s]],
    [['D3', 6 * $s], ['F2', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['D3', 6 * $s], ['F2', 6 * $s]],
    [['D3', 6 * $s], ['F2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['F3', 6 * $s], ['D3', 6 * $s]],
    [['F3', 6 * $s], ['D3', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['C3', 6 * $s], ['F2', 6 * $s]],
    [['C3', 6 * $s], ['F2', 6 * $s]],
    [['G3', 6 * $s], ['C3', 6 * $s]],
    [['G3', 6 * $s], ['C3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['A3', 6 * $s], ['D3', 6 * $s]],
    [['G3', 6 * $s], ['A#2', 6 * $s]],
    [['G3', 6 * $s], ['A#2', 6 * $s]],
    [['D3', 6 * $s], ['G2', 6 * $s]],
    [['D3', 6 * $s], ['G2', 6 * $s]],
    [['D3', 6 * $s], ['F2', 6 * $s]],
    [['D3', 6 * $s], ['F2', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['F3', 6 * $s], ['A#2', 6 * $s]],
    [['D3', 6 * $s], ['F2', 6 * $s]],
    [['D3', 6 * $s], ['F2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
    [['E3', 6 * $s], ['A2', 6 * $s]],
]);

$kicks = new SequentialClip(array_merge(
    [[['S', 4 * $s]]],
    array_fill(0, 64, [['C2', 6 * $s]])
));

$melodyTrack = Track::withBasicHandler(new PolySynth($clock), $clock);
$melodyTrack->append($melody);
$melodyTrack->append($melodyOct);

$accTrack = Track::withBasicHandler(new MonoBass($clock), $clock, .8);
$accTrack->append($accompaniment);

$kickTrack = Track::withBasicHandler(new Kick($clock), $clock);
$kickTrack->append($kicks);

return [$melodyTrack, $kickTrack, $accTrack];
