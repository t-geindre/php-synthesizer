<?php

namespace Synthesizer\Input\Producer\Midi;

use bviguier\RtMidi\Input;
use bviguier\RtMidi\MidiBrowser;
use Synthesizer\Input\Producer\Producer;

class DeviceAutoDiscover implements Producer
{
    /** @var array<string, Input> */
    private array $inputs;
    private ?Device $device = null;

    public function __construct()
    {
        $browser = new MidiBrowser();
        $inputs = $browser->availableInputs();

        if (count($inputs) === 0) {
            throw new \RuntimeException('No MIDI device found');
        }

        foreach ($inputs as $input) {
            $this->inputs[$input] = $browser->openInput($input);
        }
    }

    public function pullMessages(int $time): array
    {
        if (null === $this->device) {
            $this->discoverDevice();

            if (null === $this->device) {
                return [];
            }
        }

        return $this->device->pullMessages($time);
    }

    private function discoverDevice(): void
    {
        foreach ($this->inputs as $inputName => $input) {
            if (null !== $message = $input->pullMessage()) {
                $this->inputs = [];
                $this->device = new Device($inputName, [$message]);
                return;
            }
        }
    }

    public function getLength(): int
    {
        return Producer::INFINITE_LENGTH;
    }

    public function isOver(): bool
    {
        return false;
    }

    public function reset(): void
    {
        $this->device = null;
    }
}
