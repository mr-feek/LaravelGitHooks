<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

class CommitMsg extends CommitHookCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:commit-msg {file : the file containing the contents of the proposed commit message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git commit-msg hook';

    protected function getConfigKey(): string
    {
        return 'hooks.commit-msg';
    }
}
