<?php

namespace Feek\LaravelGitHooks\Commands;

class ComposerInstall extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:composer-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run composer install';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $composerCommand = exec('which composer');

        if (! $composerCommand) {
            $this->warn('composer not installed');
            return;
        }
        exec($composerCommand . ' install');
    }
}
