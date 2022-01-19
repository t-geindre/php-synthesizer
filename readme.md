# PHP Synthesizer

Sound Synthesizer fully written in PHP.

## Installation

First, install dependencies using [Composer](https://getcomposer.org/): `composer install`.

### Midi device

This installation part is required **only** if you want to play sound using a MIDI device/keyboard. In that case, the [RtMidi](https://github.com/thestk/rtmidi) V4 library has to be installed on your system. 

On MacOS, you can install [RtMidi](https://github.com/thestk/rtmidi) globally thanks to [`brew`](https://brew.sh/).
```bash
brew install rtmidi
``` 

:warning: On Linux, package registries often provide the V3 of this library. To get the V4 version installed, compile it:
* Download and extract [http://www.music.mcgill.ca/~gary/rtmidi/release/rtmidi-4.0.0.tar.gz](http://www.music.mcgill.ca/~gary/rtmidi/release/rtmidi-4.0.0.tar.gz)
* `./configure`
* `make && make install`
* Be sure that the library is available in you `LD_LIBRARY_PATH` or to provide the full path to `PhpRtMidi`. 

## Usage

### Output sound

All available commands generate a [Wav](https://fr.wikipedia.org/wiki/Waveform_Audio_File_Format) signal and send it to the standard output. 

The simplest option to get sound is to save this output to a file by appending `> file.wav` to the command line. Then you can play the file with any software that support wav format.

If your system provides a command that can play wav format from the standard input, you can append it to the command line using a pipe.

#### Linux  + AlsaMixer

If you're using Linux and your sound manager is AlsaMixer, you can use the `aplay` command to output sound.

For instance, to play the builtin song Tetris, run the following command: `bin/play tetris | aplay`.

The `aplay` command uses, by default, a buffer that can introduce latency if you're playing live. So, for instance if you want to play with a MIDI device, add arguments to reduce the buffer size to its minimum as it follows: `bin/midi-device | aplay --buffer-size=1 --buffer-time=1`.

### Built in songs

Run `bin/play` to play one of the builtin songs (located in `bin/songs` directory) and output wave content to stdout.

Available songs are:
 - Tetris - `bin/play tetris` The Tetris theme (short)
 - He is a pirate - `bin/play he-is-a-pirate` A short part from the song from Pirate of the caribbean movie
 - C Majors scale - `bin/play c-major-scale` C Major scale played with built-in instruments
 
### MIDI device

To play sound with a MIDI device, first make sure all [system requirements](#midi-device) are met.

The run the `bin/midi-device` command. It will read from all MIDI devices connected to your system and select the first one that send an input. If the note A0 is played, the command will switch to the next available instrument.

## Examples

If you just want to listen to some music generated by this code, just check the [examples](examples) directory.

## Thanks

 - [javidx9](https://www.youtube.com/channel/UC-yuWVUplUJZvieEligKBkA) and [his series about coding a synthesizer](https://www.youtube.com/watch?v=tgamhuQnOkM).
