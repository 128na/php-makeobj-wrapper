<?php

namespace Tests\Driver;

use Tests\TestCase;

class VersionTest extends TestCase
{
    public function testEscape()
    {
        $driver = $this->getSUT()->getDriver();
        $res = $driver->toCommand('capabilities; echo "other command"');
        exec($res, $output);

        $this->assertStringNotContainsString('other command', implode('', $output));
    }
}
