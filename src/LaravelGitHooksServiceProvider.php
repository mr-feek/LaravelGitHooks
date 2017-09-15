<?php

namespace Feek\LaravelGitHooks;

use Feek\LaravelGitHooks\Commands\CheckStyle;
use Feek\LaravelGitHooks\Commands\FixStyle;
use Feek\LaravelGitHooks\Commands\InstallHooks;
use Feek\LaravelGitHooks\Commands\CommitHooks\PreCommit;
use Feek\LaravelGitHooks\Commands\CommitHooks\PrePush;
use Feek\LaravelGitHooks\Commands\Test;
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
                CheckStyle::class,
                FixStyle::class,
                InstallHooks::class,
                Test::class,
                PreCommit::class,
                PrePush::class
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
