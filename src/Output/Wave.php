<?php

namespace Synthesizer\Output;

use Synthesizer\Time\Clock;

class Wave
{
    private int $sampleRate;
    private array $samples = [];
    private Clock $clock;

    public function __construct(int $sampleRate = 44100)
    {
        $this->sampleRate = $sampleRate;
        $this->clock = new Clock(1 / $this->sampleRate);
    }

    public function getClock() : Clock
    {
        return $this->clock;
    }

    public function addSample(int $sample)
    {
        $this->samples[] = $sample;
        $this->clock->tick();
    }

    public function flush() : void
    {
        $bps = 16; //bits per sample
        $Bps = $bps/8; //bytes per sample

        echo call_user_func_array("pack",
            array_merge(array("VVVVVvvVVvvVVv*"),
                array(//header
                    0x46464952, //RIFF
                    0, //File size
                    0x45564157, //WAVE
                    0x20746d66, //"fmt " (chunk)
                    16, //chunk size
                    1, //compression
                    1, //channels
                    $this->sampleRate, //sample rate
                    $Bps * $this->sampleRate, //bytes/second
                    $Bps, //block align
                    $bps, //bits/sample
                    0x61746164, //"data"
                    count($this->samples) * 20 //chunk size
                ),
                $this->samples
            )
        );
    }
}
