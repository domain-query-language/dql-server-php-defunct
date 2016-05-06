<?php

class Invalid implements \Infrastructure\App\DQLParser\PHPPegJS\CommandLine
{
    public function execute($command, &$result_array, &$exit_code)
    {
        $result_array = ["ERROR"];
        $exit_code = 1;
    }
}
