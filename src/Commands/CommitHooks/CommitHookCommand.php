<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

use Feek\LaravelGitHooks\CommandOutputFormatter;
use Feek\LaravelGitHooks\Commands\BaseCommand;
use Illuminate\Support\Str;

abstract class CommitHookCommand extends BaseCommand
{
    /**
     * @var \Feek\LaravelGitHooks\CommandOutputFormatter
     */
    protected $commandOutputFormatter;

    public function __construct(CommandOutputFormatter $commandOutputFormatter)
    {
        parent::__construct();
        $this->commandOutputFormatter = $commandOutputFormatter;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!config('hooks.enabled')) {
            return 0;
        }

        $commands = config($this->getConfigKey());

        if (!$commands) {
            return 0;
        }

        $this->sayHello();
        $this->line('');

        foreach ($commands as $command) {
            // these commands in the config might be the command name + options.
            $parts = explode(' ', $command, 2);
            $commandName = $parts[0];

            $arguments = isset($parts[1]) ? $parts[1] : '';

            $formattedArguments = $this->buildArgumentArrayFromArgumentString($commandName, $arguments);

            $statusCode = $this->call($commandName, $formattedArguments);

            if ($statusCode !== 0) {
                $hookName = $this->getHookName();

                $this->line('');
                $this->error($this->commandOutputFormatter->error("$hookName hook commands"));
                $this->line('');
                return $statusCode;
            }
        }

        $hookName = $this->getHookName();
        $this->line('');
        $this->info($this->commandOutputFormatter->success("$hookName hook commands"));
        $this->line('');

        return 0;
    }

    abstract protected function getConfigKey(): string;

    /**
     * Unfortunately calling artisan commands from within other artisan commands is not as simple as passing in a
     * string of arguments. Instead, they need to be formatted into an array, with extra care given for arguments
     * vs options, etc.
     *
     * @return array [];
     *  [
     *      ['--flag' => true]
     *  ]
     */
    public function buildArgumentArrayFromArgumentString(string $commandName, string $arguments = ''): array
    {
        if (!$arguments) {
            return [];
        }

        $formattedArguments = [];
        $commandBeingCalled = null;
        $requiredArguments = [];

        // regex magic for the proxy commands. see CommitHookCommandTest::it_proxies_commands_and_takes_others
        preg_match_all('~(?=\S)[^\'"\s]*(?:\'[^\']*\'[^\'"\s]*|"[^"]*"[^\'"\s]*)*~', $arguments, $results);

        foreach ($results[0] as $argument) {
            if (Str::startsWith($argument, '-') || Str::startsWith($argument, '--')) {
                if (Str::contains($argument, '=')) {
                    $parts = explode('=', $argument, 2);
                    // strip the beginning and ending quotes
                    $parts[1] = trim($parts[1], '"');

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
                // then this means that too many arguments have been passed for this command to handle
                throw new \InvalidArgumentException("calling $commandName with invalid argument from a git hook: $argument");
            }

            $argumentName = $argumentObject->getName();
            $formattedArguments[$argumentName] = $argument;
        }

        return $formattedArguments;
    }

    protected function getHookName(): string
    {
        $hookNameWithArguments = explode(':', $this->signature)[1];

        return explode(' ', $hookNameWithArguments)[0];
    }

    protected function sayHello(): void
    {
        $name = $this->getHookName();
        $this->line("<options=bold>Running $name hooks</>");
    }
}
