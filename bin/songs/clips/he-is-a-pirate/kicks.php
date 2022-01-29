<?php

use Synthesizer\Input\Producer\Clip\SequentialClip;

/** @var int $speed */

return new SequentialClip(array_merge(
    [[['S', 4 * $speed]]],
    array_fill(0, 64, [['C2', 6 * $speed]])
));
