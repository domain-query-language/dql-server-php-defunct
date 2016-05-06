<?php

class Valid implements \Infrastructure\App\DQLParser\PHPPegJS\CommandLine
{
    public function execute($command, &$result_array, &$exit_code)
    {
        $result_array = [
            'namespace PhpPegJs;',
            'class Parser{ '
        ];
    }
}
