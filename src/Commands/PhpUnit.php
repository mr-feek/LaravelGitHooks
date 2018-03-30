<?php

namespace Feek\LaravelGitHooks\Commands;

use Feek\LaravelGitHooks\CommandOutputFormatter;
use Feek\LaravelGitHooks\ProgramExecutor;

class PhpUnit extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:phpunit {--proxiedArguments=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run your applications tests';

    /**
     * @var CommandOutputFormatter
     */
    protected $commandOutputFormatter;

    /**
     * @var ProgramExecutor
     */
    protected $programExecutor;

    /**
     * Create a new command instance.
     *
     * @param CommandOutputFormatter $commandOutputFormatter
     */
    public function __construct(ProgramExecutor $programExecutor, CommandOutputFormatter $commandOutputFormatter)
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
        $arguments = $this->option('proxiedArguments');

        $this->programExecutor->exec("./vendor/bin/phpunit $arguments", $output, $statusCode);

        if ($statusCode !== 0) {
            foreach ($output as $line) {
                $this->line($line);
            }

            $this->error($this->commandOutputFormatter->error('Running PHPUnit'));
        } else {
            $this->info($this->commandOutputFormatter->success('Running PHPUnit'));
        }

        return $statusCode;
    }
}
