<?php

namespace Feek\LaravelGitHooks\Commands;

use PHPUnit\TextUI\Command;
use PHPUnit\TextUI\TestRunner;

class PhpUnit extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:phpunit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run your applications tests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('running test suite...');

        ob_start();

        $result = (new Command())->run([
            '--disallow-test-output',
            '--stop-on-failure'
        ], false);

        ob_end_clean();

        $success = ($result === TestRunner::SUCCESS_EXIT);

        if ($success) {
            $this->info('test suite passed!');
        } else {
            $this->alert('test suite failed!');
        }

        return $success ? 0 : 1;
    }
}
