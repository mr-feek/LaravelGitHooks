<?php

namespace Feek\LaravelGitHooks\Commands;

use Feek\LaravelGitHooks\ProgramExecutor;
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

    /**
     * @var ProgramExecutor
     */
    protected $programExecutor;

    /**
     * InstallDependencies constructor.
     *
     * @param Filesystem $filesystem
     * @param ProgramExecutor $programExecutor
     */
    public function __construct(Filesystem $filesystem, ProgramExecutor $programExecutor)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->programExecutor = $programExecutor;
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

        $composer = $this->programExecutor->exec('which composer');

        if (! $composer) {
            $this->warn('composer not found');
            return;
        }

        if (!$this->isFileChanged('composer.lock')) {
            $this->info('no composer changes detected');
            return;
        }

        $this->programExecutor->system($composer . ' install');
    }

    protected function yarn()
    {
        if (!$this->filesystem->exists(base_path('yarn.lock'))) {
            return;
        }

        $yarn = $this->programExecutor->exec('which yarn');

        if (! $yarn) {
            $this->warn('yarn not found');
            return;
        }

        if (!$this->isFileChanged('yarn.lock')) {
            $this->info('no yarn changes detected');
            return;
        }

        $this->programExecutor->system($yarn . ' install');
    }

    protected function npm()
    {
        if (!$this->filesystem->exists(base_path('package-lock.json'))) {
            return;
        }

        $npm = $this->programExecutor->exec('which npm');

        if (! $npm) {
            $this->warn('npm not found');
            return;
        }

        if (!$this->isFileChanged('package-lock.json')) {
            $this->info('no npm changes detected');
            return;
        }

        $this->programExecutor->system($npm . ' install');
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
        $this->programExecutor->exec("git diff --name-only --diff-filter=M HEAD -- $file", $output);
        return count($output) > 0;
    }
}
