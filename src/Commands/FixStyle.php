<?php

namespace Feek\LaravelGitHooks\Commands;

class FixStyle extends PHPCodeSnifferCommand
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
    protected $description = 'Run phpcbf on the given files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dirToFixStyle = app_path();
        $phpcbf = base_path() . '/vendor/bin/phpcbf';

        $standard = $this->getCodingStandard();

        exec(
            "$phpcbf -p --standard=$standard $dirToFixStyle",
            $output,
            $statusCode
        );

        // todo: pretty!
        $this->info(print_r($output, true));

        return $statusCode;
    }
}
