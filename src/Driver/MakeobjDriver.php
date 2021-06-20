<?php

namespace _128Na\Simutrans\Makeobj\Driver;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class MakeobjDriver
{
    public const OPTION_NONE = '';
    public const OPTION_QUIET = 'QUIET';
    public const OPTION_DEBUG = 'DEBUG';

    protected string $makeobjPath;

    public function __construct(string $makeobjPath)
    {
        $this->makeobjPath = $makeobjPath;
    }

    protected function exec(string $baseDir, string $command, ?string $option = self::OPTION_QUIET, int $exptectedCode = 0): MakeobjResponse
    {
        $command = sprintf('%s %s %s 2>&1', $this->makeobjPath, $option, $command);

        if ($baseDir) {
            $current = getcwd();
            chdir($baseDir);
        }

        exec($command, $output, $code);

        if (isset($current)) {
            chdir($current);
        }
        array_pop($output);

        return new MakeobjResponse($command, $output, $code);
    }

    /**
     * MakeObj.
     */
    public function version(): MakeobjResponse
    {
        return $this->exec('', '', self::OPTION_NONE);
    }

    /*
     * MakeObj CAPABILITIES.
     */
    public function capabilities(): MakeobjResponse
    {
        return $this->exec('', 'CAPABILITIES');
    }

    /*
     * MakeObj LIST <pak file(s)>.
     */
    public function list(array $pakFiles): MakeobjResponse
    {
        return $this->exec('', sprintf('LIST %s', implode(' ', $pakFiles)));
    }

    /*
     * MakeObj PAK <pak file> <dat file(s)>.
     */
    public function pak(int $size, string $dirPath, string $pakFile, array $datFiles, bool $debug = false): MakeobjResponse
    {
        return $this->exec(
            $dirPath,
            sprintf('PAK%d %s %s', $size, $pakFile, implode(' ', $datFiles)),
            $debug ? self::OPTION_DEBUG : self::OPTION_QUIET
        );
    }

    /*
     * MakeObj DUMP <pak file> <pak file(s)>.
     */
    public function dump(array $pakFiles): MakeobjResponse
    {
        return $this->exec('', sprintf('DUMP %s', implode(' ', $pakFiles)));
    }

    /*
     * MakeObj MERGE <pak file library> <pak file(s)>.
     */
    public function merge(string $pakFileLibrary, array $pakFiles): MakeobjResponse
    {
        return $this->exec('', sprintf('MERGE %s %s', $pakFileLibrary, implode(' ', $pakFiles)));
    }

    /*
     * MakeObj EXTRACT <pak file archive>.
     */
    public function extract(string $workdir, string $pakFileArchivcde): MakeobjResponse
    {
        return $this->exec($workdir, sprintf('EXTRACT %s', $pakFileArchivcde));
    }

    /*
     * MakeObj EXPAND <output> <dat file(s)>.
     */
    // public function expand(string $output, array $datFiles): array;
}
