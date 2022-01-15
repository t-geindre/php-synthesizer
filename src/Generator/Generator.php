<?php

namespace Synthesizer\Generator;

interface Generator
{
    public function start() : void;
    public function stop() : void;
    public function isOver() : bool;
    public function getValue() : float;
}
