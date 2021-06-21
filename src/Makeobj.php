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

    public function list(array $pakFiles): MakeobjResponse
    {
        return $this->getDriver()->list($pakFiles);
    }

    public function pak(int $size, string $dirPath, string $pakFile, array $datFiles, bool $debug = false): MakeobjResponse
    {
        return $this->getDriver()->pak($size, $dirPath, $pakFile, $datFiles, $debug);
    }

    public function dump(array $pakFiles): MakeobjResponse
    {
        return $this->getDriver()->dump($pakFiles);
    }

    public function merge(string $pakFileLibrary, array $pakFiles): MakeobjResponse
    {
        return $this->getDriver()->merge($pakFileLibrary, $pakFiles);
    }

    public function extract(string $workdir, string $pakFileArchivcde): MakeobjResponse
    {
        return $this->getDriver()->extract($workdir, $pakFileArchivcde);
    }

    // public function expand(string $output, array $datFiles): MakeobjResponse;
}
