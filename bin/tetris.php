<?php
require(__DIR__.'/../vendor/autoload.php');

use Synthesizer\Generator\Arranger\Arranger;
use Synthesizer\Generator\Arranger\Clip;
use Synthesizer\Generator\Arranger\Track;
use Synthesizer\Generator\Instrument\Bell;
use Synthesizer\Output\Wave;

$output = new Wave();
$clock = $output->getClock();

$melodyTrack = new Track(new Bell($clock), $clock);
$melodyTrack->addClip(0, new Clip(require(__DIR__.'/clips/tetris-melody.php')));

$arranger = new Arranger(0.25 * 32768); // 25% of max amplitude
$arranger->addTrack($melodyTrack);

while(!$arranger->isOver()) {
    $output->addSample((int) $arranger->getValue());
}

$output->flush();
