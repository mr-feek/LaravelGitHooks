<?php declare(strict_types=1);

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
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Feek\LaravelGitHooks\ProgramExecutor
     */
    protected $programExecutor;

    /**
     * InstallDependencies constructor.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @param \Feek\LaravelGitHooks\ProgramExecutor $programExecutor
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

    protected function composer(): void
    {
        if (!$this->filesystem->exists(base_path('composer.json'))) {
            return;
        }

        $composer = $this->programExecutor->exec('which composer');

        if (! $composer) {
            $this->warn('composer not found');
            return;
        }

        $this->programExecutor->system($composer . ' install');
    }

    protected function yarn(): void
    {
        if (!$this->filesystem->exists(base_path('yarn.lock'))) {
            return;
        }

        $yarn = $this->programExecutor->exec('which yarn');

        if (! $yarn) {
            $this->warn('yarn not found');
            return;
        }
      
        $this->programExecutor->system($yarn . ' install');
    }

    protected function npm(): void
    {
        if (!$this->filesystem->exists(base_path('package-lock.json'))) {
            return;
        }

        $npm = $this->programExecutor->exec('which npm');

        if (! $npm) {
            $this->warn('npm not found');
            return;
        }
      
        $this->programExecutor->system($npm . ' install');
    }
}
