<?php namespace Infrastructure\App\DQLParser\PHPPegJS;

interface CommandLine
{
    public function execute($command, &$result_array, &$exit_code);
}

