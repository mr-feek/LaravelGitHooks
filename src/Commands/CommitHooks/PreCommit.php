<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

class PreCommit extends CommitHookCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:pre-commit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git pre-commit hook';

    /**
     * @return string
     */
    function getConfigKey()
    {
        return 'hooks.pre-commit';
    }
}
