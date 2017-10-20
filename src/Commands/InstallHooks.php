<?php

namespace Feek\LaravelGitHooks\Commands;

use Symfony\Component\Finder\Finder;

class InstallHooks extends BaseCommand
{
    /**
     * @var Finder
     */
    private $finder;


    /**
     * InstallHooks constructor.
     * @param Finder $finder
     */
    public function __construct(Finder $finder)
    {
        parent::__construct();
        $this->finder = $finder;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs all laravel-git-hooks to the local .git hooks folder';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!config('hooks.enabled')) {
            return 0;
        }
        
        $srcPath = __DIR__ . '/../Hooks/';
        $destPath = base_path() . '/.git/hooks/';

        $this->finder->files()->in($srcPath)->name('*.sh');

        foreach ($this->finder as $file) {
            $source = $file->getRealPath();
            $destination = $destPath . $file->getRelativePathname();
            copy($source, $destination);
            chmod($destination, 0775);

            $from = str_replace(base_path(), '', realpath($source));
            $to = str_replace(base_path(), '', realpath($destination));
            $this->line('<info>Copied File</info> <comment>['.$from.']</comment> <info>To</info> <comment>['.$to.']</comment>');
        }

        return 0;
    }
}
