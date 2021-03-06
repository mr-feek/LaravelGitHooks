<?php declare(strict_types=1);

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

    protected function getConfigKey(): string
    {
        return 'hooks.pre-push';
    }
}
