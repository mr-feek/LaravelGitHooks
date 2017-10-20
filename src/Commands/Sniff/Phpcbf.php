<?php

namespace Feek\LaravelGitHooks\Commands\Sniff;

class Phpcbf extends PHPCodeSnifferCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:phpcbf {--diff}  {--proxiedArguments=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run phpcbf on the given files';

    public function getCodeSnifferExecutable()
    {
        return base_path() . '/vendor/bin/phpcbf';
    }

    /**
     * @return string
     */
    function getErrorMessage()
    {
        return 'PHPCBF failed to fix the issues.';
    }

    /**
     * @return string
     */
    function getSuccessMessage()
    {
        return 'PHPCBF fixed the issues.';
    }
}
