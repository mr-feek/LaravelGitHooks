<?php

namespace Feek\LaravelGitHooks\Commands;

use Feek\LaravelGitHooks\Traits\GitHookDelimiter;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class UninstallHooks extends BaseCommand
{

    use GitHookDelimiter;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * InstallHooks constructor.
     *
     * @param Finder $finder
     * @param Filesystem $filesystem
     */
    public function __construct(Finder $finder, Filesystem $filesystem)
    {
        parent::__construct();
        $this->finder = $finder;
        $this->filesystem = $filesystem;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all hooks inside .git/hooks/';

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

        $hooks = base_path() . '/.git/hooks/';

        $this->finder->files()->in($hooks)->name('*.sh');

        foreach ($this->finder as $file) {
            $search = '/'.$this->delimiterStart().'[\s\S]+?'.$this->delimiterEnd().'/m';
            $content = preg_replace($search, '', $file->getContents());

            $this->filesystem->put($file->getRealPath(), $content);

            $this->line('<info>Restored File</info> <comment>['.$file->getRealPath().']</comment>');
        }

        return 0;
    }
}
