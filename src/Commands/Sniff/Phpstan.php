<?php declare(strict_types=1);

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

    protected function onCommandExec(): void
    {
        $this->line('');
        $this->line('');
    }

    protected function getCodeSnifferExecutable(): string
    {
        return base_path() . '/vendor/bin/phpstan analyze';
    }
}
