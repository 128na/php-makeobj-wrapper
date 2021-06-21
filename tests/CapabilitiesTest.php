<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class CapabilitiesTest extends TestCase
{
    public function test()
    {
        $res = $this->getSUT()->capabilities();

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('This program can pack the following object types', $res->getStdOut());
    }
}
