<?php

namespace _128Na\Simutrans\Makeobj\Driver;

class WinMakeobjDriver extends MakeobjDriver
{
    protected function getDefaultMakeobjPath(): string
    {
        return realpath(__DIR__.'/../../bin/makeobj-win-60-5/makeobj.exe');
    }

    protected function handleNewline(string $str): string
    {
        return str_replace("\r", '', $str);
    }
}
