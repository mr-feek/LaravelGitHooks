<?php

namespace Feek\LaravelGitHooks\Traits;

trait GitHookDelimiter
{

    public function delimiterStart()
    {
        return '# LARAVEL GIT HOOKS BEGIN #';
    }

    public function delimiterEnd()
    {
        return '# LARAVEL GIT HOOKS END #';
    }

}
