<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class DumpTest extends TestCase
{
    public function test()
    {
        $dirpath = __DIR__.'/example';
        $pakFile = 'example.all.pak';
        $res = $this->getSUT()->dump($dirpath, $pakFile);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('000 ROOT-node (root)', $res->getStdOut());
    }
}
