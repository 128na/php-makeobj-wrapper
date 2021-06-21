<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class MergeTest extends TestCase
{
    protected function tearDown(): void
    {
        @unlink(__DIR__.'/example/merged.pak');

        parent::tearDown();
    }

    public function test()
    {
        $path1 = __DIR__.'/example/example1.pak';
        $path2 = __DIR__.'/example/example2.pak';
        $merged = __DIR__.'/example/merged.pak';
        $this->assertFalse(file_exists($merged));

        $res = $this->getSUT()->merge($merged, [$path1, $path2]);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertTrue(file_exists($merged));
        $this->assertStringContainsString('merged.pak', $res->getStdOut());
    }
}
