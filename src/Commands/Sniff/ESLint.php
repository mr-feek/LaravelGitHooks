<?php

namespace Feek\LaravelGitHooks\Commands\Sniff;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PHPUnit\TextUI\TestRunner;
use Symfony\Component\Console\Input\InputOption;

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

    /**
     * @return string
     */
    protected function getCodeSnifferExecutable()
    {
        return  base_path('/node_modules/.bin/eslint');
    }

    /**
     * @return string
     */
    protected function getFileExtension()
    {
        return 'js';
    }

    /**
     * @return string
     */
    protected function getFileLocation()
    {
        return resource_path('assets/js');
    }
}
