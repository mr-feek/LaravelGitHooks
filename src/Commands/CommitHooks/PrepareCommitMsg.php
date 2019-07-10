<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

class PrepareCommitMsg extends CommitHookCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:prepare-commit-msg {file : the file containing the contents of the proposed commit message} {source : the source of the message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git prepare-commit-msg hook';

    protected function getConfigKey(): string
    {
        return 'hooks.prepare-commit-msg';
    }
}
