<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

use Illuminate\Console\Command;

abstract class CommitHookCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (config($this->getConfigKey()) as $command) {
            // these commands in the config might be the command name + options.
            $parts = explode(' ', $command, 2);
            $commandName = $parts[0];
            $arguments = isset($parts[1]) ? explode(' ', $parts[1]) : [];

            $this->line('git hook invoking: ' . $commandName . ' ' . implode($arguments, ' '));

            // `call` expects commands to be in the format ['--flag' => true]. We need to turn this flat array into an associative array
            $formattedArguments = [];
            foreach ($arguments as $argument) {
                $formattedArguments[$argument] = true;
            }

            $statusCode = $this->call($commandName, $formattedArguments);

            if ($statusCode !== 0) {
                $this->error('git hook check failed');
                return $statusCode;
            }
        }

        $this->info('git hook checks passed!');

        return 0;
    }

    /**
     * @return string
     */
    abstract function getConfigKey();
}
