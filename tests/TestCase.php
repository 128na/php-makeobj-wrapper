<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\Driver\MakeobjDriver;
use _128Na\Simutrans\Makeobj\Makeobj;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    protected function getSUT(): Makeobj
    {
        $path = realpath(__DIR__.$_ENV['makeobj_path']);
        var_dump(__DIR__, $_ENV['makeobj_path'], $path);

        return new Makeobj(new MakeobjDriver($path));
    }
}
