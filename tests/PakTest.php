<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class PakTest extends TestCase
{
    protected function tearDown(): void
    {
        @unlink(__DIR__.'/example/testing.pak');

        parent::tearDown();
    }

    public function test()
    {
        $dirpath = __DIR__.'/example';
        $pakFile = 'testing.pak';
        $datFile = 'example.dat';

        $res = $this->getSUT()->pak($dirpath, 64, $pakFile, $datFile, true);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertTrue(file_exists($pakFile));
        $this->assertStringContainsString('testing.pak', $res->getStdOut());
        $this->assertStringContainsString('example.dat', $res->getStdOut());
        $this->assertStringContainsString('building.example1', $res->getStdOut());
        $this->assertStringContainsString('building.example2', $res->getStdOut());
    }
}
