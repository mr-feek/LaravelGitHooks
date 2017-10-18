<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

class PrepareCommitMsg extends CommitHookCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:prepare-commit-msg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git prepare-commit-msg hook';

    /**
     * @return string
     */
    function getConfigKey()
    {
        return 'hooks.prepare-commit-msg';
    }
}
