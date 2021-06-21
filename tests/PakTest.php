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
        $dir = __DIR__.'/example';
        $dat = 'example.dat';
        $pak = 'testing.pak';
        $this->assertFalse(file_exists($pak));
        $res = $this->getSUT()->pak(64, $dir, $pak, [$dat]);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertTrue(file_exists($dir.'/'.$pak));
        $this->assertStringContainsString('writing file testing', $res->getStdOut());
        $this->assertStringContainsString('reading file example.dat', $res->getStdOut());
        $this->assertStringContainsString('packing building.example', $res->getStdOut());
    }
}
