<?php

namespace Feek\Tests\Unit;

use Feek\LaravelGitHooks\CommandOutputFormatter;
use Orchestra\Testbench\TestCase;

class CommandOutputFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function it_formats_success_messages()
    {
        $formatter = new CommandOutputFormatter();
        $this->assertSame('Suh Dude.......................................... [PASSED]', $formatter->success('Suh Dude'));
    }

    /**
     * @test
     */
    public function it_formats_error_messages()
    {
        $formatter = new CommandOutputFormatter();
        $this->assertSame('Suh Dude.......................................... [ERROR]', $formatter->error('Suh Dude'));
    }

    /**
     * @test
     */
    public function it_formats_warning_messages()
    {
        $formatter = new CommandOutputFormatter();
        $this->assertSame('Suh Dude.......................................... [WARNING]', $formatter->warn('Suh Dude'));
    }
}
