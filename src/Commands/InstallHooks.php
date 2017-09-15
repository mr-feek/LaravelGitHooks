<?php

namespace Feek\LaravelGitHooks\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PHPUnit\TextUI\TestRunner;

class InstallHooks extends Command
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

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
