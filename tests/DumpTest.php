<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class DumpTest extends TestCase
{
    public function test()
    {
        $path = __DIR__.'/example/example.all.pak';
        $res = $this->getSUT()->dump([$path]);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('000 ROOT-node (root)', $res->__toString());
    }
}
