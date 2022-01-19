<?php

namespace Synthesizer\Input\Midi;

use bviguier\RtMidi\Input;
use bviguier\RtMidi\MidiBrowser;

class DeviceAutoDiscover
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

    /**
     * @return Message[]
     */
    public function pullMessages(): array
    {
        if (null === $this->device) {
            $this->discoverDevice();

            if (null === $this->device) {
                return [];
            }
        }

        return $this->device->pullMessages();
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
}
