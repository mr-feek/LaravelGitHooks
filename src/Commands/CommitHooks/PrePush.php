<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

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
    protected function getConfigKey()
    {
        return 'hooks.pre-push';
    }
}
