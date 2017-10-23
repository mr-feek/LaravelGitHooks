<?php

namespace Feek\LaravelGitHooks;

/**
 * A wrapper around language level external program executors for use in mocking
 * Class ProgramExecutor
 * @package Feek\LaravelGitHooks
 */
class ProgramExecutor
{
    public function exec($command = '', &$output = [], &$returnVal = 0)
    {
        return exec($command, $output, $returnVal);
    }

    public function system($command = '', &$returnVal = 0)
    {
        return system($command, $returnVal);
    }
}
