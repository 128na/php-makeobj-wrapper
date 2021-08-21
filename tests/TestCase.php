<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\Makeobj;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    protected function getSUT(): Makeobj
    {
        if ($_ENV['test_os'] === 'win') {
            return new Makeobj(Makeobj::OS_WIN, $_ENV['makeobj_path'] ?? null);
        }

        return new Makeobj(Makeobj::OS_LINUX, $_ENV['makeobj_path'] ?? null);
    }
}
