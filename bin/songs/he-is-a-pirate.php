<?php

use Synthesizer\Automation\Task\Variator;
use Synthesizer\Generator\Instrument\Kick;
use Synthesizer\Generator\Instrument\MonoBass;
use Synthesizer\Generator\Instrument\PolySynth;
use Synthesizer\Input\Track;

// Global song speed, higher value will slow down the song
$speed = 80;

// Melody track
/** @var \Synthesizer\Input\Producer\Clip\Clip $melody */
$melody = require(__DIR__.'/clips/he-is-a-pirate/melody.php');
$melodyOct = clone $melody;
$melodyOct->scale(12); // Upper octave

$melodyTrack = Track::withBasicHandler($synth = new PolySynth());
$melodyTrack->append($melody);
$melodyTrack->append($melodyOct);

$synth->getUnison()->setVoices(2);
$synth->getUnison()->setDetuneStep(2.5);
$synth->getUnison()->setDephaseStep(1);

// Accompaniment track
/** @var \Synthesizer\Input\Producer\Clip\Clip $accompaniment */
$accompaniment = require(__DIR__.'/clips/he-is-a-pirate/accompaniment.php');
$accTrack = Track::withBasicHandler(new MonoBass(), .7);
$accTrack->append($accompaniment);

// Kicks track
/** @var \Synthesizer\Input\Producer\Clip\Clip $kicks */
$kicks = require (__DIR__.'/clips/he-is-a-pirate/kicks.php');
$kickTrack = Track::withBasicHandler(new Kick(), 1.5);
$kickTrack->append($kicks);

// Fade out
/** @var \Synthesizer\Automation\Automation $automation */
/** @var \Synthesizer\Output\Wav $output */
$automation->addTask(new Variator(
    $melodyTrack->getLength() - 500, $melodyTrack->getLength(), $output->getVolume(), 0,
    fn (float $v) => $output->setVolume((int) $v)
));

return [$melodyTrack, $accTrack, $kickTrack];
