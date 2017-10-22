<?php

namespace Feek\LaravelGitHooks\Commands;

use Symfony\Component\Finder\Finder;

class UninstallHooks extends BaseCommand
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
            $search = '/# LARAVEL GIT HOOKS BEGIN #[\s\S]+?LARAVEL GIT HOOKS END #/m';
            $content = preg_replace($search, '', $file->getContents());

            file_put_contents($file->getRealPath(), $content);

            $this->line('<info>Restored File</info> <comment>['.$file->getRealPath().']</comment>');
        }

        return 0;
    }
}
