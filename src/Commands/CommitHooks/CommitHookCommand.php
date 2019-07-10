<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

use Feek\LaravelGitHooks\CommandOutputFormatter;
use Feek\LaravelGitHooks\Commands\BaseCommand;
use Feek\LaravelGitHooks\ProgramExecutor;

abstract class CommitHookCommand extends BaseCommand
{
    /**
     * @var \Feek\LaravelGitHooks\CommandOutputFormatter
     */
    protected $commandOutputFormatter;

    /**
     * @var \Feek\LaravelGitHooks\ProgramExecutor
     */
    protected $programExecutor;

    public function __construct(CommandOutputFormatter $commandOutputFormatter, ProgramExecutor $programExecutor)
    {
        parent::__construct();
        $this->commandOutputFormatter = $commandOutputFormatter;
        $this->programExecutor = $programExecutor;
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
            // proxy the git hook arguments that were passed to this command to the commands scheduled to be run.
            // this is an assumption that the underlying commands want these arguments, which is ok for now
            $arguments = $this->arguments();
            unset($arguments['command']);

            $command .= ' ' . (string) $this->createInputFromArguments($arguments);

            $this->info($this->commandOutputFormatter->info('invoking: ' . $command));
            $this->programExecutor->system($command, $statusCode);

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
