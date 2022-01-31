<?php

use Synthesizer\Automation\Task\Variator;
use Synthesizer\Generator\Instrument\Kick;
use Synthesizer\Generator\Instrument\MonoBass;
use Synthesizer\Generator\Instrument\PolySynth;
use Synthesizer\Input\Track;

// Global song speed, higher value will slow down the song
$speed = 50;

// Melody track
/** @var \Synthesizer\Input\Producer\Clip\Clip $melody */
$melody = require(__DIR__ . '/clips/insomnia/melody-main.php');

$synth = new PolySynth();
$synth->getUnison()->setDephaseStep(0);
$synth->getUnison()->setVoices(6);
$synth->getDelay()->setAmplitude(.4);

$melodyTrack = Track::withBasicHandler($synth);
$melodyTrack->append($melody);
$melodyTrack->appendAllAt(
    $melodyTrack->getLength() + ($introEnd = 12 * $speed),
    $melody, $melody
);

/** @var \Synthesizer\Automation\Automation $automation */

/// FadeIn, smooth song attack
/** @var \Synthesizer\Output\Output $output */
$automation->addTask(new Variator(
    0, 800, 0, $output->getVolume(),
    fn(float $v) => $output->setVolume((int) $v)
));

// Intro, tuning synth voices
$automation->addTask(new Variator(
    0, $melody->getLength(), .8, 0,
    fn(float $v) => $synth->getUnison()->setDetuneStep($v)
));

// Intro ends
$automation->addInline(
    $end = $melody->getLength() + $introEnd,
    $end,
    function () use ($synth) {
        $synth->getUnison()->setVoices(2);
        $synth->getUnison()->setDetuneStep(.8);
    }
);

// Bass
$accompaniment = require(__DIR__.'/clips/insomnia/accompaniment.php');
$bassTrack = Track::withBasicHandler(new MonoBass());
$bassTrack->addAt($melody->getLength() + 2 * $speed + $introEnd, $accompaniment);
$bassTrack->appendAll($accompaniment);

// Kicks
$kicks = require(__DIR__.'/clips/insomnia/kicks.php');
$kicksTrack = Track::withBasicHandler(new Kick(), 2.5);
$kicksTrack->addAt($melody->getLength() + 2 * $speed + $introEnd, $kicks);
$kicksTrack->appendAll($kicks);

// All tracks together
$tracks = [$melodyTrack, $kicksTrack, $bassTrack];

// Compute whole song length
$length = 0;
array_map(function(Track $track) use (&$length) {
    $length = $track->getLength() > $length ? $track->getLength() : $length;
}, $tracks);

// Fade out
$automation->addTask(new Variator(
    $length - 1000, $length, $output->getVolume(), 0,
    fn (float $v) => $output->setVolume((int) $v)
));

return $tracks;
