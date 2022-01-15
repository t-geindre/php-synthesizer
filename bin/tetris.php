<?php
require(__DIR__.'/../vendor/autoload.php');

$sampleRate = 44100;
$amplitude = 0.25 * 32768;


$partition = [
    ['E4', 400],
    ['B3', 200],
    ['C4', 200],
    ['D4', 400],
    ['C4', 200],
    ['B3', 200],
    ['A3', 400],
    ['A3', 200],
    ['C4', 200],
    ['E4', 400],
    ['D4', 200],
    ['C4', 200],
    ['B3', 600],
    ['C4', 200],
    ['D4', 400],
    ['E4', 400],
    ['C4', 400],
    ['A3', 400],
    ['A3', 400],
];

$samplesCount = array_sum(array_column($partition, '1')) * $sampleRate;

$samples = array();
$time = 0;

$clock = new \Synthesizer\Time\Clock(1 / $sampleRate);
$keyboard = new \Synthesizer\Generator\Instrument\RetroKeyboard($clock);
foreach ($partition as [$note, $duration]) {
    $sample = $duration / 1000 * $sampleRate;
    $keyboard->keyDown($note);
    while($sample-- > 0) {
        $clock->tick();
        $samples[] = (int)($keyboard->getValue() * $amplitude);
    }
    $keyboard->keyUp($note);
}

// Due to effects, the keyboard might have remaining sound to play
$keyboard->keyUpAll();
while (!$keyboard->isOver()) {
    $clock->tick();
    $samples[] = (int)($keyboard->getValue());
}

$bps = 16; //bits per sample
$Bps = $bps/8; //bytes per sample

echo call_user_func_array("pack",
    array_merge(array("VVVVVvvVVvvVVv*"),
        array(//header
            0x46464952, //RIFF
            0,      //File size
            0x45564157, //WAVE
            0x20746d66, //"fmt " (chunk)
            16, //chunk size
            1, //compression
            1, //nchannels
            $sampleRate, //sample rate
            $Bps*$sampleRate, //bytes/second
            $Bps, //block align
            $bps, //bits/sample
            0x61746164, //"data"
            $samplesCount*20 //chunk size
        ),
        $samples //data
    )
);

