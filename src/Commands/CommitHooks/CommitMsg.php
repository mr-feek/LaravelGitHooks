<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

class CommitMsg extends CommitHookCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:commit-msg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git commit-msg hook';

    /**
     * @return string
     */
    protected function getConfigKey()
    {
        return 'hooks.commit-msg';
    }
}
