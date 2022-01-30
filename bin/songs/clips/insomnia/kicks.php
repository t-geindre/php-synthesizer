<?php

use Synthesizer\Input\Producer\Clip\SequentialClip;

/** @var int $speed */

return new SequentialClip(array_merge(
    array_fill(0, 8, [['G1', 10 * $speed]])
));
