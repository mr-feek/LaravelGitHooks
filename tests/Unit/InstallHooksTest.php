<?php

namespace Feek\LaravelGitHooks\Unit;

use Feek\LaravelGitHooks\LaravelGitHooksServiceProvider;
use Feek\LaravelGitHooks\Traits\GitHookDelimiter;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use Orchestra\Testbench\TestCase;

class InstallHooksTest extends TestCase
{
    use GitHookDelimiter;

    /** @test */
    public function it_keeps_the_user_defined_tests()
    {
        $mock = $this->bootstrapFilesystemMock();
        $mock->shouldReceive('exists')->andReturn(true);
        $mock->shouldReceive('get')->with(Mockery::anyOf(
            base_path().'/.git/hooks/post-checkout.sh',
            base_path().'/.git/hooks/pre-commit.sh',
            base_path().'/.git/hooks/pre-push.sh',
            base_path().'/.git/hooks/prepare-commit-msg.sh'))->andReturn('user defined git hook');
        $mock->shouldReceive('put')->withArgs([
            Mockery::any(),
            Mockery::on(function ($value) {
                return str_contains($value, 'user defined git hook');
            }),
        ]);
        $mock->shouldReceive('chmod');

        $this->artisan('hooks:install');
    }

    private function bootstrapFilesystemMock()
    {
        $mock = Mockery::mock(Filesystem::class);

        $this->app->instance(Filesystem::class, $mock);

        return $mock;
    }

    /** @test */
    public function it_appends_the_laravel_git_hooks()
    {
        $mock = $this->bootstrapFilesystemMock();
        $mock->shouldReceive('exists')->andReturn(false);
        $mock->shouldReceive('get')->with(Mockery::anyOf(
            base_path().'/.git/hooks/post-checkout.sh',
            base_path().'/.git/hooks/pre-commit.sh',
            base_path().'/.git/hooks/pre-push.sh',
            base_path().'/.git/hooks/prepare-commit-msg.sh'))->andReturn('');
        $mock->shouldReceive('put')->withArgs([
            Mockery::any(),
            Mockery::on(function ($value) {
                return str_contains($value, $this->delimiterStart());
            }),
        ]);
        $mock->shouldReceive('chmod');

        $this->artisan('hooks:install');
    }

    /** @test */
    public function it_replaces_the_previous_installed_laravel_git_hooks()
    {
        $mock = $this->bootstrapFilesystemMock();
        $mock->shouldReceive('exists')->andReturn();
        $mock->shouldReceive('get')
             ->with(Mockery::anyOf(
                 base_path().'/.git/hooks/post-checkout.sh',
                 base_path().'/.git/hooks/pre-commit.sh',
                 base_path().'/.git/hooks/pre-push.sh',
                 base_path().'/.git/hooks/prepare-commit-msg.sh'))
             ->andReturn($this->delimiterStart().'user defined git hook'.$this->delimiterEnd());
        $mock->shouldReceive('put')->withArgs([
            Mockery::any(),
            Mockery::on(function ($value) {
                return ! str_contains($value, 'user defined git hook');
            }),
        ]);
        $mock->shouldReceive('chmod');

        $this->artisan('hooks:install');
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelGitHooksServiceProvider::class,
        ];
    }
}
