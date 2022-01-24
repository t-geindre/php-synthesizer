<?php

use Synthesizer\Generator\Arranger\SequentialClip;
use Synthesizer\Generator\Arranger\Track;
use Synthesizer\Generator\Instrument\Kick;

$melodyNotes = ['C3', 'D3', 'E3', 'F3', 'G3', 'A3', 'B3', 'C4', 'D4', 'E4', 'F4', 'G4', 'A4', 'B4'];
$melodyMaxIndex = count($melodyNotes) - 1;

$bassChords = [
    ['C2', 'G2'],
    ['D2', 'A3'],
    ['E2', 'B3'],
    ['F2', 'C3'],
    ['G2', 'D3'],
    ['A2', 'E3'],
    ['B2', 'F3'],
];

$melodyPartition = [];
$melodyIndex = ceil($melodyMaxIndex / 2);
for ($i = 0; $i < 100; $i++) {
    $melodyPartition[] = [
        $melodyNotes[$melodyIndex],
        [200, 400, 600][mt_rand(0, 1)]
    ];
    $melodyIndex += [-2, -1, 0, 1, 2][mt_rand(0, 4)];
    $melodyIndex = min($melodyMaxIndex, max(0 ,$melodyIndex));
}

/** @var \Synthesizer\Time\Clock $clock*/
$melodyTrack = new Track(new \Synthesizer\Generator\Instrument\Kick($clock), $clock, 1);
$melodyTrack->addClip(0, new SequentialClip($melodyPartition));

return [$melodyTrack];
