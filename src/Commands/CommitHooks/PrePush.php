<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

use Feek\LaravelGitHooks\Commands\CommitHooks\CommitHookCommand;

class PrePush extends CommitHookCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:pre-push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git pre-push hook';

    /**
     * @return string
     */
    function getConfigKey()
    {
        return 'hooks.pre-push';
    }
}
