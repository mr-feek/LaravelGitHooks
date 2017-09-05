<?php

namespace Feek\LaravelGitHooks\Commands;

use Illuminate\Console\Command;

class FixStyle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:fix-style';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $dirToFixStyle = app_path();
        $phpcbf = base_path() . '/vendor/bin/phpcbf';

        exec(
            "$phpcbf -p --standard=PSR2 $dirToFixStyle",
            $output,
            $statusCode
        );

        // todo: pretty!
        $this->info(print_r($output, true));

        return $statusCode;
    }
}
