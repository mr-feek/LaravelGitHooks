<?php

namespace Feek\LaravelGitHooks\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class PHPCodeSnifferCommand extends Command
{
    /**
     * @return string
     */
    public function getCodingStandard()
    {
        return config('hooks.php-standard');
    }

    /**
     * @return string
     */
    abstract function getCodeSnifferExecutable();

    /**
     * @return string
     */
    abstract function getErrorMessage();

    /**
     * @return string
     */
    abstract function getSuccessMessage();

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            ['diff', null, InputOption::VALUE_OPTIONAL, 'only pass the currently staged files']
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filesToCheck = app_path();

        if ($this->option('diff')) {
            // only check the current files that are staged
            exec(
                'git diff --cached --name-only --diff-filter=ACMR HEAD',
                $filesToCheck
            );

            $filesToCheck = implode($filesToCheck, ' ');
        }

        $executable = $this->getCodeSnifferExecutable();
        $standard = $this->getCodingStandard();

        exec(
            "$executable -p --standard=$standard $filesToCheck",
            $output,
            $statusCode
        );

        if ($statusCode !== 0) {
            foreach ($output as $line) {
                $this->line($line);
            }

            $this->error($this->getErrorMessage());
        } else {
            $this->info($this->getSuccessMessage());
        }

        return $statusCode;
    }
}
