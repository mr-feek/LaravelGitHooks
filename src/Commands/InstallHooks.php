<?php declare(strict_types=1);

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
     * @var \Symfony\Component\Finder\Finder
     */
    private $finder;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * InstallHooks constructor.
     *
     * @param \Symfony\Component\Finder\Finder $finder
     * @param \Illuminate\Filesystem\Filesystem $filesystem
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

        $srcPath = __DIR__ . '/../Hooks/';
        $destPath = base_path() . '/.git/hooks/';

        $this->finder->files()->in($srcPath)->name('*.sh');

        foreach ($this->finder as $file) {
            $source = $file->getRealPath();
            $destination = $destPath . $file->getRelativePath() . $file->getBasename('.sh');

            $hookDefinition = PHP_EOL . $this->delimiterStart() . PHP_EOL . $file->getContents() . PHP_EOL . $this->delimiterEnd() . PHP_EOL;
            // @see https://www.php.net/manual/en/function.preg-replace.php#103985 for the need to escape `$`
            $hookDefinition = preg_replace('/\$(\d)/', '\\\$$1', $hookDefinition);


            $previousHookDefinition = $this->filesystem->exists($destination) ? $this->filesystem->get($destination) : '';

            // check if this package has been installed before. If so, replace the contents without overwriting
            // anything that may have been added by the user
            $search = '/' . preg_quote($this->delimiterStart()) . '[\s\S]+?' . preg_quote($this->delimiterEnd()) . '/m';
            if (preg_match($search, $previousHookDefinition)) {
                $contentsToWrite = preg_replace($search, $hookDefinition, $previousHookDefinition);
            } else {
                $contentsToWrite = $previousHookDefinition . $hookDefinition;
            }

            $this->filesystem->put($destination, $contentsToWrite);
            $this->filesystem->chmod($destination, 0775);

            $from = str_replace(base_path(), '', realpath($source));
            $to = str_replace(base_path(), '', realpath($destination));
            $this->line('<info>Copied File</info> <comment>[' . $from . ']</comment> <info>To</info> <comment>[' . $to . ']</comment>');
        }

        return 0;
    }
}
