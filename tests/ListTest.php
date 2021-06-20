<?php

namespace Tests;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class ListTest extends TestCase
{
    public function test()
    {
        $path = __DIR__.'/example/example.pak';
        $res = $this->getSUT()->list([$path]);

        $this->assertEquals(0, $res->getCode());
        $this->assertInstanceOf(MakeobjResponse::class, $res);
        $this->assertStringContainsString('example 1!"#$%&\'()=~|-^\@[]`{};+:*,./\?_>', $res->__toString());
    }
}
