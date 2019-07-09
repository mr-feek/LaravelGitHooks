<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Commands\Sniff;

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

    protected function getCodeSnifferExecutable(): string
    {
        return base_path() . '/vendor/bin/phpcs';
    }
}
