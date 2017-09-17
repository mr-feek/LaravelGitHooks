<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

abstract class CommitHookCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $commands = config($this->getConfigKey());

        if ($commands) {
            foreach ($commands as $command) {
                // these commands in the config might be the command name + options.
                $parts = explode(' ', $command, 2);
                $commandName = $parts[0];
                $arguments = isset($parts[1]) ? explode(' ', $parts[1]) : [];

                $formattedArguments = $this->buildArgumentArrayFromArgumentString($commandName, $arguments);

                $this->line('git hook invoking: ' . $commandName . ' ' . implode($arguments, ' '));

                $statusCode = $this->call($commandName, $formattedArguments);

                if ($statusCode !== 0) {
                    $this->error('git hook check failed');
                    return $statusCode;
                }
            }
        }

        $this->info('git hook checks passed!');

        return 0;
    }

    /**
     * @return string
     */
    abstract function getConfigKey();

    /**
     * Unfortunately calling artisan commands from within other artisan commands is not as simple as passing in a
     * string of arguments. Instead, they need to be formatted into an array, with extra care given for arguments
     * vs options, etc.
     *
     * @param string $commandName
     * @param string[] $arguments
     *  ['27', '--diff', '--lines=45'']
     *
     * @return array [];
     *  [
     *      ['--flag' => true]
     *  ]
     */
    public function buildArgumentArrayFromArgumentString($commandName, $arguments)
    {
        $formattedArguments = [];
        $commandBeingCalled = null;
        $requiredArguments = [];

        foreach ($arguments as $argument) {
            if (Str::startsWith($argument, '--')) {
                if (Str::contains($argument, '=')) {
                    $parts = explode('=', $argument);
                    $formattedArguments[$parts[0]] = $parts[1];
                    continue;
                }

                $formattedArguments[$argument] = true;
                continue;
            }

            // then it is an *argument*, not option
            // need to somehow get the string name of the argument from the command class we r gonna call
            if (!$commandBeingCalled) {
                $commandBeingCalled = $this->getApplication()->find($commandName);
                $requiredArguments = $commandBeingCalled->getDefinition()->getArguments();
            }

            // grab the next argument and remove it from the array to avoid maintaining a pointer
            $argumentObject = array_shift($requiredArguments);
            if (!$argumentObject) {
                // todo: improve messaging
                throw new \InvalidArgumentException('calling an artisan command with invalid arguments from a git hook.');
            }

            $argumentName = $argumentObject->getName();
            $formattedArguments[$argumentName] = $argument;
        }

        return $formattedArguments;
    }
}
