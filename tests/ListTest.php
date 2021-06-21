<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class ListTest extends TestCase
{
    public function test()
    {
        $dirpath = __DIR__.'/example';
        $file = 'example.all.pak';
        $res = $this->getSUT()->list($dirpath, $file);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('example1', $res->getStdOut());
        $this->assertStringContainsString('example2', $res->getStdOut());
    }
}
