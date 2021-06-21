<?php

namespace _128Na\Simutrans\Makeobj;

class MakeobjResponse
{
    public string $command;
    public string $stdout;
    public string $stderr;
    public int $code;

    public function __construct(string $command, string $stdout, string $stderr, int $code)
    {
        $this->command = $command;
        $this->stdout = $stdout;
        $this->stderr = $stderr;
        $this->code = $code;
    }

    public function __toString()
    {
        return "--- stdout ---\n{$this->stdout}\n--- stderr ---\n{$this->stderr}";
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getStdOut(): string
    {
        return $this->stdout;
    }

    public function getStdOutAsArray(): array
    {
        return explode("\n", $this->stdout);
    }

    public function getStdErr(): string
    {
        return $this->stderr;
    }

    public function getStdErrAsArray(): array
    {
        return explode("\n", $this->stderr);
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
