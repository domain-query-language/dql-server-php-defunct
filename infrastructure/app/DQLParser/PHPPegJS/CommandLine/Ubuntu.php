<?php namespace Infrastructure\App\DQLParser\PHPPegJS\CommandLine;

class Ubuntu implements \Infrastructure\App\DQLParser\PHPPegJS\CommandLine
{
    public function execute($command, &$result_array, &$exit_code)
    {
        exec($command, $result_array, $exit_code);
    }
}
