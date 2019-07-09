<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Traits;

trait GitHookDelimiter
{
    public function delimiterStart(): string
    {
        return '# LARAVEL GIT HOOKS BEGIN #';
    }

    public function delimiterEnd(): string
    {
        return '# LARAVEL GIT HOOKS END #';
    }
}
