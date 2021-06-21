<?php

namespace _128Na\Simutrans\Makeobj\Driver;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

class MakeobjDriver
{
    public const OPTION_NONE = '';
    public const OPTION_QUIET = 'QUIET';
    public const OPTION_DEBUG = 'DEBUG';

    public const OS_LINUX = 'linux';
    public const OS_WIN = 'win';
    public const OS_MAC = 'mac';

    private string $os;
    private string $makeobjPath;

    public function __construct(?string $os = self::OS_LINUX, ?string $makeobjPath = null)
    {
        $this->os = $os ?? self::OS_LINUX;
        $this->makeobjPath = $makeobjPath ?? $this->getDefaultMakeobjPath();
    }

    private function getDefaultMakeobjPath(): string
    {
        switch ($this->os) {
            case self::OS_WIN:
                return realpath(__DIR__.'/../../bin/makeobj-win-60-5/makeobj.exe');
            case self::OS_LINUX:
            default:
                return realpath(__DIR__.'/../../bin/makeobj-linux-60-2/makeobj');
        }
    }

    private function exec(string $baseDir, string $command): MakeobjResponse
    {
        if ($baseDir) {
            $current = getcwd();
            chdir($baseDir);
        }

        $descriptorspec = [
        ['pipe', 'r'],  // stdin
        ['pipe', 'w'],  // stdout
        ['pipe', 'w'],  // stdout
    ];
        $cwd = null;
        $env = null;
        $options = [
        'bypass_shell' => true, // (windows のみ): true にすると、cmd.exe シェルをバイパスします。
    ];

        $process = proc_open($command, $descriptorspec, $pipes, $cwd, $env, $options);

        if (!is_resource($process)) {
            throw new \Exception('proc_open failed.');
        }

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $code = proc_close($process);

        if (isset($current)) {
            chdir($current);
        }

        return new MakeobjResponse($command, $stdout, $stderr, $code);
    }

    /**
     * コマンド化.
     */
    private function toCommand(string $command, ?string $option = self::OPTION_QUIET): string
    {
        return sprintf('%s %s %s', $this->makeobjPath, $option, $command);
    }

    /**
     * MakeObj.
     */
    public function version(): MakeobjResponse
    {
        return $this->exec(
        '',
        $this->toCommand('', self::OPTION_NONE)
    );
    }

    /*
    * MakeObj CAPABILITIES.
    */
    public function capabilities(): MakeobjResponse
    {
        return $this->exec(
        '',
        $this->toCommand('CAPABILITIES')
    );
    }

    /*
    * MakeObj LIST <pak file(s)>.
    */
    public function list(array $pakFiles): MakeobjResponse
    {
        return $this->exec(
        '',
        $this->toCommand(sprintf('LIST %s', implode(' ', $pakFiles)))
    );
    }

    /*
    * MakeObj PAK <pak file> <dat file(s)>.
    */
    public function pak(int $size, string $dirPath, string $pakFile, array $datFiles, bool $debug = false): MakeobjResponse
    {
        $option = $debug ? self::OPTION_DEBUG : self::OPTION_QUIET;

        return $this->exec(
        $dirPath,
        $this->toCommand(sprintf('PAK%d %s %s', $size, $pakFile, implode(' ', $datFiles)), $option)
    );
    }

    /*
    * MakeObj DUMP <pak file> <pak file(s)>.
    */
    public function dump(array $pakFiles): MakeobjResponse
    {
        return $this->exec(
        '',
        $this->toCommand(sprintf('DUMP %s', implode(' ', $pakFiles)))
    );
    }

    /*
    * MakeObj MERGE <pak file library> <pak file(s)>.
    */
    public function merge(string $pakFileLibrary, array $pakFiles): MakeobjResponse
    {
        return $this->exec(
        '',
        $this->toCommand(sprintf('MERGE %s %s', $pakFileLibrary, implode(' ', $pakFiles)))
    );
    }

    /*
    * MakeObj EXTRACT <pak file archive>.
    */
    public function extract(string $workdir, string $pakFileArchivcde): MakeobjResponse
    {
        return $this->exec(
        $workdir,
        $this->toCommand(sprintf('EXTRACT %s', $pakFileArchivcde))
    );
    }

    /*
    * MakeObj EXPAND <output> <dat file(s)>.
    */
// public function expand(string $output, array $datFiles): array;
}
