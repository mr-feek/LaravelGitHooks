<?php

namespace Feek\LaravelGitHooks\Commands;

use Illuminate\Filesystem\Filesystem;

class InstallDependencies extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:install-deps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs composer install, if available';

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->composer();
    }

    protected function composer()
    {
        if (!$this->filesystem->exists(base_path('composer.json'))) {
            return;
        }

        $composerCommand = exec('which composer');

        if (! $composerCommand) {
            $this->warn('composer not found');
            return;
        }

        exec($composerCommand . ' install');
    }
}
