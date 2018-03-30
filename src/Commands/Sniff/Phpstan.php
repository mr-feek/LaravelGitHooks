<?php

namespace Feek\LaravelGitHooks\Commands\Sniff;

class Phpstan extends PHPCodeSnifferCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:phpstan {--diff} {--proxiedArguments=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run phpstan on the given files. Refer to https://github.com/Weebly/phpstan-laravel';

    /**
     * @return string
     */
    protected function getCodeSnifferExecutable()
    {
        return base_path() . '/vendor/bin/phpstan analyze';
    }
}
