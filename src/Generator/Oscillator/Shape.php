<?php

namespace Synthesizer\Generator\Oscillator;

use Synthesizer\Shape\Shape as ShapeFunction;

class Shape implements Oscillator
{
    private ShapeFunction $shape;

    public function __construct(float $from, ShapeFunction $shape)
    {
        $shape->setValueFrom($from);
        $this->shape = $shape;
    }

    public function getValue(float $deltaTime): float
    {
        if ($deltaTime > $this->shape->getDuration()) {
            return $this->shape->getTargetValue();
        }

        return $this->shape->getValue($deltaTime);
    }
}
