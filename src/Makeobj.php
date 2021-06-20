<?php

namespace _128Na\Simutrans\Makeobj;

use _128Na\Simutrans\Makeobj\Driver\MakeobjDriver;

class Makeobj
{
    public const OPTION_NONE = '';
    public const OPTION_QUIET = 'QUIET';
    public const OPTION_DEBUG = 'DEBUG';

    protected MakeobjDriver $driver;

    public function __construct(MakeobjDriver $driver)
    {
        $this->driver = $driver;
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
