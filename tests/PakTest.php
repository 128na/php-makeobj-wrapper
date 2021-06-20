<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class PakTest extends TestCase
{
    protected function tearDown(): void
    {
        $paked = __DIR__.'/example/testing.pak';
        @unlink($paked);

        parent::tearDown();
    }

    public function test()
    {
        $dir = __DIR__.'/example';
        $dat = 'example.dat';
        $pak = 'testing';
        $res = $this->getSUT()->pak(64, $dir, $pak, [$dat]);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('writing file testing', $res->__toString());
        $this->assertStringContainsString('reading file example.dat', $res->__toString());
        $this->assertStringContainsString('packing building.example', $res->__toString());
    }
}
