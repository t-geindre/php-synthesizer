<?php

use Synthesizer\Input\Track;
use Synthesizer\Generator\Instrument\Bell;
use Synthesizer\Input\Producer\Clip\SequentialClip;

$melodyNotes = ['C3', 'D3', 'E3', 'F3', 'G3', 'A3', 'B3', 'C4', 'D4', 'E4', 'F4', 'G4', 'A4', 'B4'];
$melodyMaxIndex = count($melodyNotes) - 1;

$melodyPartition = [];
$melodyIndex = ceil($melodyMaxIndex / 2);
for ($i = 0; $i < 100; $i++) {
    $melodyPartition[] = [[
        $melodyNotes[$melodyIndex],
        [200, 400][mt_rand(0, 1)]
    ]];
    $melodyIndex += [-2, -1, 0, 1, 2][mt_rand(0, 4)];
    $melodyIndex = min($melodyMaxIndex, max(0 ,$melodyIndex));
}

/** @var \Synthesizer\Time\Clock\Clock $clock */
$melodyTrack = Track::withBasicHandler(new Bell($clock), $clock);
$melodyTrack->append(new SequentialClip($melodyPartition));

return [$melodyTrack];
