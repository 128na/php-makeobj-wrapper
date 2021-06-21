<?php

namespace _128Na\Simutrans\Makeobj\Driver;

use _128Na\Simutrans\Makeobj\MakeobjResponse;

abstract class MakeobjDriver
{
    public const OPTION_NONE = '';
    public const OPTION_QUIET = 'QUIET';
    public const OPTION_DEBUG = 'DEBUG';

    private string $makeobjPath;

    public function __construct(?string $makeobjPath = null)
    {
        $this->makeobjPath = $makeobjPath ?? $this->getDefaultMakeobjPath();
    }

    /**
     * デフォルトのmakeobj実行ファイルのパス.
     */
    abstract protected function getDefaultMakeobjPath(): string;

    /**
     * 文字列内の改行コードを\nに統一する.
     */
    abstract protected function handleNewline(string $str): string;

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

        return new MakeobjResponse(
            $command,
            $this->handleNewline($stdout),
            $this->handleNewline($stderr),
            $code
        );
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
    public function list(string $dir, string $pakFile): MakeobjResponse
    {
        return $this->exec(
            $dir,
            $this->toCommand(sprintf('LIST %s', $pakFile))
        );
    }

    /*
    * MakeObj PAK <pak file> <dat file(s)>.
    */
    public function pak(string $dir, int $size, string $pakFile, string $datFile, bool $debug = false): MakeobjResponse
    {
        $option = $debug ? self::OPTION_DEBUG : self::OPTION_QUIET;

        return $this->exec(
            $dir,
            $this->toCommand(sprintf('PAK%d %s %s', $size, $pakFile, $datFile), $option)
        );
    }

    /*
    * MakeObj DUMP <pak file> <pak file(s)>.
    */
    public function dump(string $dir, string $pakFile): MakeobjResponse
    {
        return $this->exec(
            $dir,
            $this->toCommand(sprintf('DUMP %s', $pakFile))
        );
    }

    /*
    * MakeObj MERGE <pak file library> <pak file(s)>.
    */
    public function merge(string $dir, string $pakFileLibrary, string $pakFile): MakeobjResponse
    {
        return $this->exec(
            $dir,
            $this->toCommand(sprintf('MERGE %s %s', $pakFileLibrary, $pakFile))
        );
    }

    /*
    * MakeObj EXTRACT <pak file archive>.
    */
    public function extract(string $dir, string $pakFileArchivcde): MakeobjResponse
    {
        return $this->exec(
            $dir,
            $this->toCommand(sprintf('EXTRACT %s', $pakFileArchivcde))
        );
    }

    /*
    * MakeObj EXPAND <output> <dat file(s)>.
    */
    // public function expand(string $output, array $datFiles): array;
}
