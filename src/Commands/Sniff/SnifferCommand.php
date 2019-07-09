<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Commands\Sniff;

use Feek\LaravelGitHooks\CommandOutputFormatter;
use Feek\LaravelGitHooks\Commands\BaseCommand;
use Feek\LaravelGitHooks\ProgramExecutor;
use Symfony\Component\Console\Input\InputOption;

abstract class SnifferCommand extends BaseCommand
{
    /**
     * @var \Feek\LaravelGitHooks\ProgramExecutor
     */
    protected $programExecutor;

    /**
     * @var \Feek\LaravelGitHooks\CommandOutputFormatter
     */
    protected $commandOutputFormatter;

    /**
     * SnifferCommand constructor.
     *
     * @param \Feek\LaravelGitHooks\ProgramExecutor $programExecutor
     * @param \Feek\LaravelGitHooks\CommandOutputFormatter $commandOutputFormatter
     */
    public function __construct(ProgramExecutor $programExecutor, CommandOutputFormatter $commandOutputFormatter)
    {
        parent::__construct();
        $this->programExecutor = $programExecutor;
        $this->commandOutputFormatter = $commandOutputFormatter;
    }

    abstract protected function getCodeSnifferExecutable(): string;

    abstract protected function getFileExtension(): string;

    abstract protected function getFileLocation(): string;

    /**
     * @return array
     */
    public function getOptions(): array
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

            $this->programExecutor->exec(
                'git diff --cached --name-only --diff-filter=ACMR HEAD -- "*.' . $this->getFileExtension() . '"',
                $filesToCheck
            );

            $filesToCheck = implode($filesToCheck, ' ');

            if (!$filesToCheck) {
                $this->warn($this->commandOutputFormatter->warn($this->getBaseMessage()));
                $this->warn('No files found to sniff.');
                return 0;
            }
        }

        $executable = $this->getCodeSnifferExecutable();

        $additionalFlags = $this->option('proxiedArguments');

        $this->programExecutor->exec(
            "$executable $additionalFlags $filesToCheck",
            $output,
            $statusCode
        );

        $this->onCommandExec();

        if ($statusCode !== 0) {
            foreach ($output as $line) {
                $this->line($line);
            }

            $this->error($this->commandOutputFormatter->error($this->getBaseMessage()));
        } else {
            $this->info($this->commandOutputFormatter->success($this->getBaseMessage()));
        }

        return $statusCode;
    }

    protected function getCommandName(): string
    {
        $commandName = explode(':', $this->signature)[1];

        return ucfirst(explode(' ', $commandName)[0]);
    }

    protected function getBaseMessage(): string
    {
        $name = $this->getCommandName();
        return "Analyzing code with $name";
    }

    protected function onCommandExec(): void
    {
        // noop by default
    }
}
