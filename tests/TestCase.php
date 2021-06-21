<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\Driver\MakeobjDriver;
use _128Na\Simutrans\Makeobj\Makeobj;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    protected function getSUT(): Makeobj
    {
        if ($_ENV['test_os'] === 'win') {
            return new Makeobj(new MakeobjDriver(MakeobjDriver::OS_WIN));
        }

        return new Makeobj(new MakeobjDriver());
    }
}
