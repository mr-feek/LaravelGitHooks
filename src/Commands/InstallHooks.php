<?php

namespace Feek\LaravelGitHooks\Commands;

class InstallHooks extends BaseCommand
{
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
        $srcPath = __DIR__ . '/../Hooks/';
        $destPath = base_path() . '/.git/hooks/';

        $files = ['pre-commit', 'pre-push'];

        foreach($files as $file) {
            $source = $srcPath . $file . '.sh';
            $destination = $destPath . $file;
            copy($source, $destination);
            chmod($destination, 0775);
            
            $this->info("copied $source to $destination");
        }

        return 0;
    }
}
