<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks\Tests\Unit;

use Feek\LaravelGitHooks\LaravelGitHooksServiceProvider;
use Feek\LaravelGitHooks\Traits\GitHookDelimiter;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;

class InstallHooksTest extends TestCase
{
    use GitHookDelimiter;

    /** @test */
    public function it_keeps_the_user_defined_tests(): void
    {
        $mock = $this->bootstrapFilesystemMock();
        $mock->shouldReceive('exists')->andReturn(true);
        $mock->shouldReceive('get')->with(Mockery::anyOf(
            base_path() . '/.git/hooks/post-checkout',
            base_path() . '/.git/hooks/pre-commit',
            base_path() . '/.git/hooks/pre-push',
            base_path() . '/.git/hooks/commit-msg',
            base_path() . '/.git/hooks/prepare-commit-msg'
        ))->andReturn('user defined git hook');
        $mock->shouldReceive('put')->withArgs([
            Mockery::any(),
            Mockery::on(function ($value) {
                return str_contains($value, 'user defined git hook');
            }),
        ]);
        $mock->shouldReceive('chmod');

        $this->artisan('hooks:install');
    }

    private function bootstrapFilesystemMock(): MockInterface
    {
        $mock = Mockery::mock(Filesystem::class);

        $this->app->instance(Filesystem::class, $mock);

        return $mock;
    }

    /** @test */
    public function it_appends_the_laravel_git_hooks(): void
    {
        $mock = $this->bootstrapFilesystemMock();
        $mock->shouldReceive('exists')->andReturn(false);
        $mock->shouldReceive('get')->with(Mockery::anyOf(
            base_path() . '/.git/hooks/post-checkout',
            base_path() . '/.git/hooks/pre-commit',
            base_path() . '/.git/hooks/pre-push',
            base_path() . '/.git/hooks/prepare-commit-msg'
        ))->andReturn('');
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
    public function it_replaces_the_previous_installed_laravel_git_hooks(): void
    {
        $mock = $this->bootstrapFilesystemMock();
        $mock->shouldReceive('exists')->andReturn();
        $mock->shouldReceive('get')
             ->with(Mockery::anyOf(
                 base_path() . '/.git/hooks/post-checkout',
                 base_path() . '/.git/hooks/pre-commit',
                 base_path() . '/.git/hooks/pre-push',
                 base_path() . '/.git/hooks/prepare-commit-msg'
             ))
             ->andReturn($this->delimiterStart() . 'user defined git hook' . $this->delimiterEnd());
        $mock->shouldReceive('put')->withArgs([
            Mockery::any(),
            Mockery::on(function ($value) {
                return ! str_contains($value, 'user defined git hook');
            }),
        ]);
        $mock->shouldReceive('chmod');

        $this->artisan('hooks:install');
    }

    /**
     * @inheritdoc
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelGitHooksServiceProvider::class,
        ];
    }
}
