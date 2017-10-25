<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

class PostCheckout extends CommitHookCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:post-checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git post-checkout hook';

    /**
     * @return string
     */
    protected function getConfigKey()
    {
        return 'hooks.post-checkout';
    }
}
