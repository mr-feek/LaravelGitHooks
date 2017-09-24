<?php
/**
 * Created by PhpStorm.
 * User: Feek
 * Date: 9/15/17
 * Time: 9:21 PM
 */

namespace Feek\LaravelGitHooks\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class SnifferCommand extends BaseCommand
{
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
     * @return string
     */
    abstract function getFileExtension();

    /**
     * @return string
     */
    abstract function getFileLocation();

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            ['diff', null, InputOption::VALUE_OPTIONAL, 'only pass the currently staged files'],
            ['proxiedArguments', null, InputOption::VALUE_OPTIONAL, 'argument list to pass to the underlying process being executed'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filesToCheck = $this->getFileLocation();

        if ($this->option('diff')) {
            // only check the current files that are staged
            $filesToCheck = [];

            exec(
                'git diff --cached --name-only --diff-filter=ACMR HEAD -- "*.' . $this->getFileExtension() . '"',
                $filesToCheck
            );

            $filesToCheck = implode($filesToCheck, ' ');

            if (!$filesToCheck) {
                $this->warn('did not find any files to sniff');
                return 0;
            }
        }

        $executable = $this->getCodeSnifferExecutable();

        $additionalFlags = $this->option('proxiedArguments');

        exec(
            "$executable $additionalFlags $filesToCheck",
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
