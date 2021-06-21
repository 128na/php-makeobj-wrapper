<?php

namespace _128Na\Simutrans\Makeobj\Driver;

class LinuxMakeobjDriver extends MakeobjDriver
{
    protected function getDefaultMakeobjPath(): string
    {
        return realpath(__DIR__.'/../../bin/makeobj-linux-60-2/makeobj');
    }

    protected function handleNewline(string $str): string
    {
        return $str;
    }
}
