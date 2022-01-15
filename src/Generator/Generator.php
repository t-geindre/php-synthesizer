<?php

namespace Synthesizer\Generator;

interface Generator
{
    public function isOver() : bool;
    public function getValue() : float;
}
