<?php

namespace _128Na\Simutrans\Makeobj;

use _128Na\Simutrans\Makeobj\Driver\LinuxMakeobjDriver;
use _128Na\Simutrans\Makeobj\Driver\MakeobjDriver;
use _128Na\Simutrans\Makeobj\Driver\WinMakeobjDriver;

class Makeobj
{
    public const OS_LINUX = 'linux';
    public const OS_WIN = 'win';
    public const OS_MAC = 'mac';

    protected string $os;
    protected MakeobjDriver $driver;

    public function __construct(?string $os = self::OS_LINUX, ?string $makeobjPath = null)
    {
        $this->os = $os;
        $this->driver = $this->setupDriver($makeobjPath = null);
    }

    protected function setupDriver(?string $makeobjPath = null): MakeobjDriver
    {
        switch ($this->os) {
            case self::OS_WIN:
                return new WinMakeobjDriver($makeobjPath = null);
            case self::OS_LINUX:
            default:
                return new LinuxMakeobjDriver($makeobjPath = null);
        }
    }

    public function getDriver(): MakeobjDriver
    {
        return $this->driver;
    }

    public function version(): MakeobjResponse
    {
        return $this->getDriver()->version();
    }

    public function capabilities(): MakeobjResponse
    {
        return $this->getDriver()->capabilities();
    }

    public function list(string $dir, string $pakFile): MakeobjResponse
    {
        return $this->getDriver()->list($dir, $pakFile);
    }

    public function pak(string $dir, int $size, string $pakFile, string $datFile, bool $debug = false): MakeobjResponse
    {
        return $this->getDriver()->pak($dir, $size, $pakFile, $datFile, $debug);
    }

    public function dump(string $dir, string $pakFile): MakeobjResponse
    {
        return $this->getDriver()->dump($dir, $pakFile);
    }

    public function merge(string $dir, string $pakFileLibrary, string $pakFile): MakeobjResponse
    {
        return $this->getDriver()->merge($dir, $pakFileLibrary, $pakFile);
    }

    public function extract(string $dir, string $pakFileArchive): MakeobjResponse
    {
        return $this->getDriver()->extract($dir, $pakFileArchive);
    }

    // public function expand(string $output, array $datFiles): MakeobjResponse;
}
