<?php

namespace Feek\Tests\Unit;

use Feek\LaravelGitHooks\Commands\CommitHooks\CommitHookCommand;
use Mockery;
use Orchestra\Testbench\TestCase;
use Symfony\Component\Console\Application;

class CommitHookCommandTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_throws_exception_if_invalid_arguments_supplied()
    {
        $command = $this->bootstrapTestCommand();

        $command->buildArgumentArrayFromArgumentString('fake:command2', '1 2 3 4 5 6 7 8 9 10');
    }

    /**
     * @test
     */
    public function it_formats_options()
    {
        $command = $this->bootstrapTestCommand();

        $formatted = $command->buildArgumentArrayFromArgumentString('fake:command2', '--drinkAll');

        $this->assertSame([
            '--drinkAll' => true
        ], $formatted);
    }

    /**
     * @test
     */
    public function it_formats_required_arguments()
    {
        $command = $this->bootstrapTestCommand();

        $formatted = $command->buildArgumentArrayFromArgumentString('fake:command2', '27');

        $this->assertSame([
            'budLites' => '27'
        ], $formatted);
    }

    /**
     * @test
     */
    public function it_formats_optional_arguments()
    {
        $command = $this->bootstrapTestCommand();

        $formatted = $command->buildArgumentArrayFromArgumentString('fake:command2', '27 12');

        $this->assertSame([
            'budLites' => '27',
            'coronas' => '12'
        ], $formatted);
    }

    /**
     * @test
     */
    public function it_formats_arguments_and_options()
    {
        $command = $this->bootstrapTestCommand();

        $formatted = $command->buildArgumentArrayFromArgumentString('fake:command2', '27 12 --beers=10');

        $this->assertSame([
            'budLites' => '27',
            'coronas' => '12',
            '--beers' => '10'
        ], $formatted);
    }

    /**
     * @test
     */
    public function it_proxies_commands()
    {
        $command = $this->bootstrapProxyTestCommand();

        $formatted = $command->buildArgumentArrayFromArgumentString('fake:proxy:command', '--proxiedArguments="1 3 --suh"');

        $this->assertSame([
            '--proxiedArguments' => '1 3 --suh',
        ], $formatted);
    }

    /**
     * @test
     */
    public function it_proxies_commands_and_takes_others()
    {
        $command = $this->bootstrapProxyTestCommand();

        $formatted = $command->buildArgumentArrayFromArgumentString('fake:proxy:command', '--jawn --proxiedArguments="1 3 --suh --dude=you"');

        $this->assertSame([
            '--jawn' => true,
            '--proxiedArguments' => '1 3 --suh --dude=you',
        ], $formatted);
    }

    /**
     * @return TestCommand
     */
    protected function bootstrapTestCommand()
    {
        $command = new TestCommand();

        $appMock = Mockery::mock(Application::class)->makePartial();
        $appMock->shouldReceive('find')->with('fake:command2')->andReturn(new TestCommand2());

        $command->setApplication($appMock);
        return $command;
    }

    /**
     * @return ProxyTestCommand
     */
    protected function bootstrapProxyTestCommand()
    {
        $command = new ProxyTestCommand();

        $appMock = Mockery::mock(Application::class)->makePartial();
        $appMock->shouldReceive('find')->with('fake:proxy:command')->andReturn(new ProxyTestCommand());

        $command->setApplication($appMock);
        return $command;
    }
}

class TestCommand extends CommitHookCommand
{
    protected $signature = 'fake:command';

    /**
     * @return string
     */
    protected function getConfigKey()
    {
        return 'N/A';
    }
}

class TestCommand2 extends CommitHookCommand
{
    protected $signature = 'fake:command2 {budLites} {coronas?} {{--all}} {{--beers=10}}';

    /**
     * @return string
     */
    protected function getConfigKey()
    {
        return 'N/A';
    }
}

class ProxyTestCommand extends CommitHookCommand
{
    protected $signature = 'fake:proxy:command  {--proxiedArguments=} {--jawn?}';

    /**
     * @return string
     */
    protected function getConfigKey()
    {
        return 'N/A';
    }
}
