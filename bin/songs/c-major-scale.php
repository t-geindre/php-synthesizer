<?php
use Synthesizer\Input\Track;
use Synthesizer\Input\Producer\Clip\SequentialClip;

/** @var \Synthesizer\Time\Clock\Clock $clock */

$clip = new SequentialClip([
    [['C4', 1000]],
    [['S', 1000]],
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
    new \Synthesizer\Generator\Instrument\Organ($clock),
    new \Synthesizer\Generator\Instrument\Bell($clock),
    new \Synthesizer\Generator\Instrument\Kick($clock),
    new \Synthesizer\Generator\Instrument\MonoBass($clock),
    new \Synthesizer\Generator\Instrument\PolySynth($clock)
] as $index => $instrument) {
    $track = Track::withBasicHandler($instrument, $clock);
    $track->addAt(
        clone $clip,
        $clip->getLength() * $index + ($index > 0 ? 100 : 0)
    );
    $tracks[] = $track;
}

return $tracks;
