<?php
use Synthesizer\Input\Track;
use Synthesizer\Input\Producer\Clip\SequentialClip;
use Synthesizer\Generator\Instrument\Organ;
use Synthesizer\Generator\Instrument\Bell;
use Synthesizer\Generator\Instrument\Kick;
use Synthesizer\Generator\Instrument\MonoBass;
use Synthesizer\Generator\Instrument\PolySynth;

/** @var \Synthesizer\Time\Clock $clock*/

$clip = new SequentialClip([
    [['C4', 300]],
    [['S', 100]],
    [['D4', 300]],
    [['S', 100]],
    [['E4', 300]],
    [['S', 100]],
    [['F4', 300]],
    [['S', 100]],
    [['G4', 300]],
    [['S', 100]],
    [['A4', 300]],
    [['S', 100]],
    [['B4', 300]],
    [['S', 100]],
    [['C5', 300]],
    [['S', 100]],
    [['B4', 300]],
    [['S', 100]],
    [['A4', 300]],
    [['S', 100]],
    [['G4', 300]],
    [['S', 100]],
    [['F4', 300]],
    [['S', 100]],
    [['E4', 300]],
    [['S', 100]],
    [['D4', 300]],
    [['S', 100]],
    [['C4', 300]],
]);

$tracks = [];

foreach ([
    new Organ($clock),
    new Bell($clock),
    new Kick($clock),
    new MonoBass($clock),
    new PolySynth($clock)
] as $index => $instrument) {
    $track = Track::withBasicHandler($instrument, $clock);
    $track->addAt(
        clone $clip,
        $clip->getLength() * $index + ($index > 0 ? 100 : 0)
    );
    $tracks[] = $track;
}

return $tracks;
