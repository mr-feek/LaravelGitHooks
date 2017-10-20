<?php

namespace Feek\LaravelGitHooks\Commands\Sniff;

abstract class PHPCodeSnifferCommand extends SnifferCommand
{
    public function getFileExtension()
    {
        return 'php';
    }

    public function getFileLocation()
    {
        return app_path();
    }
}
