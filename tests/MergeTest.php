<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class MergeTest extends TestCase
{
    protected function tearDown(): void
    {
        @unlink(__DIR__.'/example/mergetest.pak');

        parent::tearDown();
    }

    public function test()
    {
        $dir = __DIR__.'/example';
        $pakFile = 'example1.pak example2.pak';
        $pakFileLibrary = 'mergetest.pak';

        $res = $this->getSUT()->merge($dir, $pakFileLibrary, $pakFile);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertTrue(file_exists($dir.'/'.$pakFileLibrary));
        $this->assertStringContainsString('mergetest.pak', $res->getStdOut());
    }
}
