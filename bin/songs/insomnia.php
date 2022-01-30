<?php

use Synthesizer\Automation\Task\FadeOut;
use Synthesizer\Automation\Task\Variator;
use Synthesizer\Generator\Instrument\Kick;
use Synthesizer\Generator\Instrument\MonoBass;
use Synthesizer\Generator\Instrument\PolySynth;
use Synthesizer\Input\Track;

/** @var \Synthesizer\Time\Clock\Clock $clock*/

// Global song speed, higher value will slow down the song
$speed = 50;

// Melody track
/** @var \Synthesizer\Input\Producer\Clip\Clip $melody */
$melody = require(__DIR__.'/clips/insomnia/melody.php');
/** @var \Synthesizer\Input\Producer\Clip\Clip $melodyUp */
$melodyUp = require(__DIR__.'/clips/insomnia/melody-up.php');

$synth = new PolySynth($clock);
$synth->getUnison()->setDephaseStep(0);
$synth->getUnison()->setVoices(6);
$synth->getDelay()->setAmplitude(.4);

$melodyTrack = Track::withBasicHandler($synth, $clock);
$melodyTrack->appendAll($melody, $melody, $melodyUp);
$melodyTrack->appendAllAt(
    $melodyTrack->getLength() + ($introEnd = 12) * $speed,
    $melody, $melody, $melodyUp
);
$melodyTrack->appendAll($melody, $melody, $melodyUp);

/** @var \Synthesizer\Automation\Automation $automation */

/// FadeIn, smooth song attack
$automation->addTask(new Variator(
    0, 800, 0, 1,
    fn(float $v) => $melodyTrack->setAmplitude($v)
));

// Intro, tuning synth voices
$automation->addTask(new Variator(
    0, $melody->getLength() * 3, .8, 0,
    fn(float $v) => $synth->getUnison()->setDetuneStep($v)
));

// Intro ends
$automation->addInline(
    $end = $melody->getLength() * 3 + $introEnd * $speed,
    $end,
    function () use ($synth) {
        $synth->getUnison()->setVoices(2);
        $synth->getUnison()->setDetuneStep(1);
        $synth->getUnison()->setDephaseStep(1);
    }
);

// Bass
$accompaniment = require(__DIR__.'/clips/insomnia/accompaniment.php');
$bassTrack = Track::withBasicHandler(new MonoBass($clock), $clock);
$bassTrack->addAt($melody->getLength() * 3 + (2 + $introEnd) * $speed, $accompaniment);
$bassTrack->appendAll($accompaniment, $accompaniment);
$bassTrack->appendAll($accompaniment, $accompaniment, $accompaniment);

// Kicks
$kicks = require(__DIR__.'/clips/insomnia/kicks.php');
$kicksTrack = Track::withBasicHandler(new Kick($clock), $clock, 2.5);
$kicksTrack->addAt($melody->getLength() * 3 + (2 + $introEnd) * $speed, $kicks);
$kicksTrack->appendAll($kicks, $kicks);
$kicksTrack->appendAll($kicks, $kicks, $kicks);

// Bass

// Fade out
/** @var \Synthesizer\Output\Output $output */
$automation->addTask(new Variator(
    $melodyTrack->getLength() - 1000, $melodyTrack->getLength(), $output->getVolume(), 0,
    fn (float $v) => $output->setVolume((int) $v)
));

return [$melodyTrack, $kicksTrack, $bassTrack];
