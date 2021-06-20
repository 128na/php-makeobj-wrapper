<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class VersionTest extends TestCase
{
    public function test()
    {
        $makeobj = $this->getSUT();
        $res = $makeobj->version();
        var_dump($res);

        $this->assertEquals(3, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('Makeobj version', $res->__toString());
    }
}
