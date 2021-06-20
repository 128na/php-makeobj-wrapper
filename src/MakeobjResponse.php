<?php

namespace _128Na\Simutrans\Makeobj;

class MakeobjResponse
{
    public string $command;
    public array $output;
    public int $code;

    public function __construct(string $command, array $output, int $code)
    {
        $this->command = $command;
        $this->output = $output;
        $this->code = $code;
    }

    public function __toString()
    {
        return implode("\n", $this->output);
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getOutput(): array
    {
        return $this->output;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
