<?php
use Synthesizer\Generator\Arranger\Track;
use Synthesizer\Generator\Arranger\SequentialClip;
use Synthesizer\Generator\Arranger\Clip;
use Synthesizer\Generator\Instrument\Retro;
use Synthesizer\Generator\Instrument\Piano;

/** @var \Synthesizer\Time\Clock $clock*/
$melodyTrack = new Track(new Piano($clock), $clock, 1);
$melodyTrack->addClip(0, new SequentialClip([
    ['D4', 400],
    ['E4', 400],
    ['F4', 600], // D2/A2
    ['G4', 200],
    ['A4', 400],
    ['G4', 600], // C2/G2
    ['F4', 200],
    ['E4', 200],
    ['F4', 400], // F1/C2
    ['G4', 400],
    ['A4', 400],
    ['G4', 600], // C2/G2
    ['F4', 200],
    ['G4', 200],
    ['A4', 600], // F1/C2
    ['G4', 200],
    ['F4', 400],
    ['E4', 400], // A1/D2
    ['F4', 400],
    ['E4', 400],
    ['D4', 600],// D2/A2
    ['E4', 200],
    ['C4', 400],
    ['D4', 1200],// D1/A1
]));

$bassTrack = new Track(new Retro($clock), $clock, 0.5);
$bassTrack->addClip(800, new Clip([
    ['D2', 0, 1200],
    ['A2', 0, 1200],

    ['C2', 1200, 1000],
    ['G2', 1200, 1000],

    ['F1', 2200, 1200],
    ['C2', 2200, 1200],

    ['C2', 3400, 1000],
    ['G2', 3400, 1000],

    ['F1', 4400, 1200],
    ['C2', 4400, 1200],

    ['A1', 5600, 1200],
    ['E2', 5600, 1200],

    ['D2', 6800, 1200],
    ['A2', 6800, 1200],

    ['D2', 8000, 1200],
    ['A2', 8000, 1200],
]));

return [$melodyTrack, $bassTrack];
