<?php

namespace Feek\LaravelGitHooks\Commands;

use Illuminate\Console\Command;

class PrePush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:pre-push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git pre-push hook';

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
        return $this->call('hooks:test');
    }
}
