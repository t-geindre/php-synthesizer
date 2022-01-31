<?php
use Synthesizer\Input\Track;
use Synthesizer\Input\Producer\Clip\SequentialClip;

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
    new \Synthesizer\Generator\Instrument\Organ(),
    new \Synthesizer\Generator\Instrument\Bell(),
    new \Synthesizer\Generator\Instrument\Kick(),
    new \Synthesizer\Generator\Instrument\MonoBass(),
    new \Synthesizer\Generator\Instrument\PolySynth()
] as $index => $instrument) {
    $track = Track::withBasicHandler($instrument);
    $track->addAt(
        $clip->getLength() * $index + ($index > 0 ? 100 : 0),
        clone $clip,
    );
    $tracks[] = $track;
}

return $tracks;
