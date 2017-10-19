<?php

namespace Feek\LaravelGitHooks;

use Feek\LaravelGitHooks\Commands\ComposerInstall;
use Feek\LaravelGitHooks\Commands\ESLint;
use Feek\LaravelGitHooks\Commands\Phpcs;
use Feek\LaravelGitHooks\Commands\Phpcbf;
use Feek\LaravelGitHooks\Commands\InstallHooks;
use Feek\LaravelGitHooks\Commands\CommitHooks\PreCommit;
use Feek\LaravelGitHooks\Commands\CommitHooks\PrePush;
use Feek\LaravelGitHooks\Commands\CommitHooks\PrepareCommitMsg;
use Feek\LaravelGitHooks\Commands\CommitHooks\PostCheckout;
use Feek\LaravelGitHooks\Commands\PhpUnit;
use Illuminate\Support\ServiceProvider;

class LaravelGitHooksServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ComposerInstall::class,
                ESLint::class,
                Phpcs::class,
                Phpcbf::class,
                InstallHooks::class,
                PhpUnit::class,
                PreCommit::class,
                PrePush::class,
                PrepareCommitMsg::class,
                PostCheckout::class
            ]);

            $this->publishes([
                __DIR__.'/Config/hooks.php' => config_path('hooks.php'),
            ]);

            $this->mergeConfigFrom(
                __DIR__.'/Config/hooks.php', 'hooks'
            );
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
