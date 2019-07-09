<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks;

/**
 * A wrapper around language level external program executors for use in mocking
 * Class ProgramExecutor
 * @package Feek\LaravelGitHooks
 */
class ProgramExecutor
{
    public function exec(string $command = '', array &$output = [], int &$returnVal = 0): string
    {
        return exec($command, $output, $returnVal);
    }

    /**
     * @return bool|string
     */
    public function system(string $command = '', int &$returnVal = 0)
    {
        return system($command, $returnVal);
    }
}
