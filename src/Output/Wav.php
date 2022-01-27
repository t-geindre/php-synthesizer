<?php

namespace Synthesizer\Output;

use Synthesizer\Time\Clock\Basic;
use Synthesizer\Time\Clock\Clock;

class Wav
{
    private int $sampleRate;
    const MAX_AMPLITUDE = 32767;
    private float $volume;
    private Clock $clock;

    public function __construct(int $sampleRate = 44100, int $volume = 20)
    {
        $this->sampleRate = $sampleRate;
        $this->writeHeaders();
        $this->volume = $volume / 100;
        $this->clock = new Basic(1000 / $sampleRate);
    }

    public function getClock(): Clock
    {
        return $this->clock;
    }

    public function setClock(Clock $clock): void
    {
        $this->clock = $clock;
    }

    public function addSample(float $sample) : void
    {
        $this->write('v', (int) ($sample * $this->volume * self::MAX_AMPLITUDE));
        $this->clock->tick();
    }

    public function getSampleRate(): int
    {
        return $this->sampleRate;
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

    /**
     * @param mixed ...$data
     */
    private function write(string $format, ...$data) : void
    {
        echo pack($format, ...$data);
    }
}
