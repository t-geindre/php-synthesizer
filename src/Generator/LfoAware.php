<?php

namespace Synthesizer\Generator;

interface LfoAware
{
    public function setLfo(?Generator $lfo): void;
}
