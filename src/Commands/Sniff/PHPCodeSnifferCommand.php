<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Commands\Sniff;

abstract class PHPCodeSnifferCommand extends SnifferCommand
{
    public function getFileExtension(): string
    {
        return 'php';
    }

    public function getFileLocation(): string
    {
        return app_path();
    }
}
