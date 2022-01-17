<?php

namespace Synthesizer\Output;

use Synthesizer\Time\Clock;

class Wav
{
    private int $sampleRate;
    private Clock $clock;

    public function __construct(int $sampleRate = 44100)
    {
        $this->sampleRate = $sampleRate;
        $this->clock = new Clock(1 / $this->sampleRate);
        $this->writeHeaders();
    }

    public function getClock() : Clock
    {
        return $this->clock;
    }

    public function addSample(int $sample)
    {
        $this->write('v', $sample);
        $this->clock->tick();
    }

    private function writeHeaders() : void
    {
        $bps = 16; //bits per sample
        $Bps = $bps/8; //bytes per sample

        $this->write('VVVVVvvVVvvVV',
            0x46464952, //RIFF
            0, //File size todo in file output, calculate actual size
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
            0xFFFFFFFF, // chunk size todo in file output, filesize - headers (content/samples)
        );
    }

    private function write(string $format, ...$data)
    {
        echo pack($format, ...$data);
    }
}
