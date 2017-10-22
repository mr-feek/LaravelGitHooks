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

        if (!$this->isFileChanged('composer.lock')) {
            $this->info('no composer changes detected');
            return;
        }

        if (!$this->confirm('Should we install the composer dependencies?')) {
            return;
        }

        system($composer . ' install');
    }

    protected function yarn()
    {
        if (!$this->filesystem->exists(base_path('yarn.lock'))) {
            return;
        }

        $yarn = exec('which yarn');

        if (! $yarn) {
            $this->warn('yarn not found');
            return;
        }

        if (!$this->isFileChanged('yarn.lock')) {
            $this->info('no yarn changes detected');
            return;
        }

        if (!$this->confirm('Should we install the yarn dependencies?')) {
            return;
        }

        system($yarn . ' install');
    }

    protected function npm()
    {
        if (!$this->filesystem->exists(base_path('package-lock.json'))) {
            return;
        }

        $npm = exec('which npm');

        if (! $npm) {
            $this->warn('npm not found');
            return;
        }

        if (!$this->isFileChanged('package-lock.json')) {
            $this->info('no npm changes detected');
            return;
        }

        if (!$this->confirm('Should we install the npm dependencies?')) {
            return;
        }

        system($npm . ' install');
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    protected function isFileChanged($file)
    {
        // this command is probably only ever going to be run just after checking out another branch, so just assume
        // to check in "git diff"
        exec( "git diff --name-only --diff-filter=M HEAD -- $file", $output);
        return count($output) > 0;
    }
}
