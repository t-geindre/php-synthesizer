<?php

namespace Synthesizer\Reference;

class Scaler
{
    /**
     * @var array<int, string>|null
     */
    private static ?array $keys = null;


    /**
     * @var array<string, int>|null
     */
    private static ?array $flippedKeys = null;

    public static function scaleNote(string $note, int $scale): string
    {
        self::init();

        if (!isset(self::$flippedKeys[$note])) {
            throw new \InvalidArgumentException(sprintf('Unknown note "%s"', $note));

        }

        $scaled = self::$flippedKeys[$note] - $scale;

        if (!isset(self::$keys[$scaled])) {
            throw new \InvalidArgumentException(sprintf('Unable to scale "%s" %d, out of range', $note, $scale));
        }

        return self::$keys[$scaled];
    }

    private static function init(): void
    {
        if (null === self::$keys) {
            self::$keys = array_keys(Frequencies::FREQUENCIES);
            self::$flippedKeys = array_flip(self::$keys);
        }
    }
}
