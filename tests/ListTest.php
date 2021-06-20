<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class ListTest extends TestCase
{
    public function test()
    {
        $path = __DIR__.'/example/example.all.pak';
        $res = $this->getSUT()->list([$path]);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('example1', $res->__toString());
        $this->assertStringContainsString('example2', $res->__toString());
    }
}
