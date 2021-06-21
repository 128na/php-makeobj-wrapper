<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class ExtractTest extends TestCase
{
    protected function tearDown(): void
    {
        @unlink(__DIR__.'/example/extract/building.example1.pak');
        @unlink(__DIR__.'/example/extract/building.example2.pak');

        parent::tearDown();
    }

    public function test()
    {
        $merged = __DIR__.'/example/example.all.pak';
        $dest = __DIR__.'/example/extract';

        $res = $this->getSUT()->extract($dest, $merged);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('building.example1.pak', $res->getStdOut());
        $this->assertStringContainsString('building.example2.pak', $res->getStdOut());
        $this->assertTrue(file_exists(__DIR__.'/example/extract/building.example1.pak'));
        $this->assertTrue(file_exists(__DIR__.'/example/extract/building.example2.pak'));
    }
}
