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
    protected $description = 'Installs php and javascript dependencies, if available';

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
        $this->yarn();
        $this->npm();
    }

    protected function composer()
    {
        if (!$this->filesystem->exists(base_path('composer.json'))) {
            return;
        }

        $composer = exec('which composer');

        if (! $composer) {
            $this->warn('composer not found');
            return;
        }

        exec($composer . ' install');
    }

    private function yarn()
    {
        if (!$this->filesystem->exists(base_path('yarn.lock'))) {
            return;
        }

        $yarn = exec('which yarn');

        if (! $yarn) {
            $this->warn('yarn not found');
            return;
        }

        exec($yarn . ' install');
    }

    private function npm()
    {
        if (!$this->filesystem->exists(base_path('package.lock'))) {
            return;
        }

        $npm = exec('which npm');

        if (! $npm) {
            $this->warn('npm not found');
            return;
        }

        exec($npm . ' install');
    }
}
