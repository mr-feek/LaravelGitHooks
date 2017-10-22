<?php

namespace Feek\LaravelGitHooks\Commands\Sniff;

use Feek\LaravelGitHooks\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputOption;

abstract class SnifferCommand extends BaseCommand
{
    /**
     * @return string
     */
    abstract protected function getCodeSnifferExecutable();

    /**
     * @return string
     */
    abstract protected function getFileExtension();

    /**
     * @return string
     */
    abstract protected function getFileLocation();

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

    /**
     * @return string
     */
    public function getSuccessMessage()
    {
        return $this->pad($this->getBaseMessage(), '[' . $this->getCommandName() . ' PASSED]');
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->pad($this->getBaseMessage(), '[' . $this->getCommandName() . ' FAILED]');
    }

    protected function getCommandName()
    {
        $commandName = explode(':', $this->signature)[1];

        return ucfirst(explode(' ', $commandName)[0]);
    }

    protected function getBaseMessage()
    {
        $name = $this->getCommandName();
        return "Analyzing code with $name";
    }

    /**
     * @param $message
     * @param $status
     *
     * @return string
     */
    protected function pad($message, $status)
    {
        return str_pad($message, 50, '.') . $status;
    }
}
