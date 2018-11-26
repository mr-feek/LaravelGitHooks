<?php

return [
    'commands' => [
        \Feek\LaravelGitHooks\Commands\InstallHooks::class,
        \Feek\LaravelGitHooks\Commands\CommitHooks\CommitMsg::class,
        \Feek\LaravelGitHooks\Commands\CommitHooks\PreCommit::class,
        \Feek\LaravelGitHooks\Commands\CommitHooks\PrepareCommitMsg::class,
        \Feek\LaravelGitHooks\Commands\CommitHooks\PrePush::class,
        \Feek\LaravelGitHooks\Commands\CommitHooks\PostCheckout::class,
        \Feek\LaravelGitHooks\Commands\Sniff\Phpcs::class,
        \Feek\LaravelGitHooks\Commands\Sniff\Phpcbf::class,
        \Feek\LaravelGitHooks\Commands\Sniff\Phpstan::class,
        \Feek\LaravelGitHooks\Commands\PhpUnit::class,
        \Feek\LaravelGitHooks\Commands\InstallDependencies::class,
        \Feek\LaravelGitHooks\Commands\SemanticCommitMessages::class,
    ],
];
