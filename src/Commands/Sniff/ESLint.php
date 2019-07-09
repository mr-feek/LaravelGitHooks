<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Commands\Sniff;

class ESLint extends SnifferCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:eslint {--diff}  {--proxiedArguments=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs ESLint';

    protected function getCodeSnifferExecutable(): string
    {
        return base_path('/node_modules/.bin/eslint');
    }

    protected function getFileExtension(): string
    {
        return 'js';
    }

    protected function getFileLocation(): string
    {
        return resource_path('assets/js');
    }
}
