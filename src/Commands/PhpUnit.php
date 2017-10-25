<?php

namespace Feek\LaravelGitHooks\Commands;

use Feek\LaravelGitHooks\CommandOutputFormatter;
use PHPUnit\TextUI\Command;
use PHPUnit\TextUI\TestRunner;

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
     * Create a new command instance.
     *
     * @param CommandOutputFormatter $commandOutputFormatter
     */
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
        ob_start();

        $result = (new Command())->run([
            '--disallow-test-output',
            '--stop-on-failure'
        ], false);

        ob_end_clean();

        $success = ($result === TestRunner::SUCCESS_EXIT);

        if ($success) {
            $this->info($this->commandOutputFormatter->success('Running PHPUnit'));
        } else {
            $this->error($this->commandOutputFormatter->error('Running PHPUnit'));
        }

        return $success ? 0 : 1;
    }
}
