<?php

use Synthesizer\Input\Producer\Clip\Clip;

/** @var Clip $clip */

$clip = require(__DIR__.'/melody.php');

$partition = $clip->getPartition();

// Replace 4 first D4 by F#4
$left = 4;
foreach ($partition as [&$note,]) {
    if ($note == 'D4') {
        $note = 'F#4';
        if (--$left == 0) {
            break;
        }
    }
}

return new Clip($partition);
