<?php

namespace Feek\LaravelGitHooks\Commands;

class Phpcs extends PHPCodeSnifferCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:phpcs {--diff} {--proxiedArguments=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run phpcs on the given files';

    /**
     * @return string
     */
    function getCodeSnifferExecutable()
    {
        return base_path() . '/vendor/bin/phpcs';
    }

    /**
     * @return string
     */
    function getErrorMessage()
    {
        return 'PHP Code Sniffer did not pass. Try running `php artisan hooks:phpcbf` to automatically fix';
    }

    /**
     * @return string
     */
    function getSuccessMessage()
    {
        return 'PHP Code Sniffer Passed!';
    }
}
