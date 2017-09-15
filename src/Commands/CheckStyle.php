<?php

namespace Feek\LaravelGitHooks\Commands;

class CheckStyle extends PHPCodeSnifferCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:check-style';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run phpcs on the given files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dirToCheckStyle = app_path();
        $phpcs = base_path() . '/vendor/bin/phpcs';

        $this->info('running phpcs...');

        $standard = $this->getCodingStandard();

        exec(
            "$phpcs -p --standard=$standard $dirToCheckStyle",
                $output,
                $statusCode
        );

        if ($statusCode !== 0) {
            // todo: pretty!
            $this->alert(print_r($output, true));
            $this->error('Please ensure your code meets this projects styleguide. Automatically fix by running \'php artisan hooks:fix-style\'');
        } else {
            $this->info('phpcs passed!');
        }

        return $statusCode;
    }
}
