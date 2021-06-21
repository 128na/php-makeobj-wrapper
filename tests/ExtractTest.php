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
        $dir = __DIR__.'/example/extract';
        $pakFileLibrary = 'example.all.pak';

        $res = $this->getSUT()->extract($dir, $pakFileLibrary);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('building.example1.pak', $res->getStdOut());
        $this->assertStringContainsString('building.example2.pak', $res->getStdOut());
        $this->assertTrue(file_exists(__DIR__.'/example/extract/building.example1.pak'));
        $this->assertTrue(file_exists(__DIR__.'/example/extract/building.example2.pak'));
    }
}
