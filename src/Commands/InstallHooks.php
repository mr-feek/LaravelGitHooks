<?php

namespace Feek\LaravelGitHooks\Commands;

use Feek\LaravelGitHooks\Traits\GitHookDelimiter;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class InstallHooks extends BaseCommand
{
    use GitHookDelimiter;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! config('hooks.enabled')) {
            return 0;
        }

        $srcPath = __DIR__.'/../Hooks/';
        $destPath = base_path().'/.git/hooks/';

        $this->finder->files()->in($srcPath)->name('*.sh');

        foreach ($this->finder as $file) {
            $source = $file->getRealPath();
            $destination = $destPath.$file->getRelativePath().$file->getBasename('.sh');

            $sourceContent = PHP_EOL.$this->delimiterStart().PHP_EOL.$file->getContents().PHP_EOL.$this->delimiterEnd().PHP_EOL;
            $destinationContent = $this->filesystem->exists($destination) ? $this->filesystem->get($destination) : '';

            if (str_contains($destinationContent, $this->delimiterStart())) {
                $search = '/'.$this->delimiterStart().'[\s\S]+?'.$this->delimiterEnd().'/m';
                $destinationContent = preg_replace($search, $sourceContent, $destinationContent);
            } else {
                $destinationContent .= $sourceContent;
            }

            $this->filesystem->put($destination, $destinationContent);
            $this->filesystem->chmod($destination, 0775);

            $from = str_replace(base_path(), '', realpath($source));
            $to = str_replace(base_path(), '', realpath($destination));
            $this->line('<info>Copied File</info> <comment>['.$from.']</comment> <info>To</info> <comment>['.$to.']</comment>');
        }

        return 0;
    }
}
