<?php

namespace Feek\Tests\Unit;

use Feek\LaravelGitHooks\Commands\Sniff\ESLint;
use Feek\LaravelGitHooks\Commands\Sniff\Phpcs;
use Orchestra\Testbench\TestCase;

class SnifferCommandOutputTest extends TestCase
{
    /**
     * @test
     */
    public function it_displays_padded_success_message()
    {
        $command = new Phpcs();
        $this->assertSame('Analyzing code with Phpcs.........................[Phpcs PASSED]', $command->getSuccessMessage());

        $command = new ESLint();
        $this->assertSame('Analyzing code with Eslint........................[Eslint PASSED]', $command->getSuccessMessage());
    }

    /**
     * @test
     */
    public function it_displays_padded_error_message()
    {
        $command = new Phpcs();
        $this->assertSame('Analyzing code with Phpcs.........................[Phpcs FAILED]', $command->getErrorMessage());

        $command = new ESLint();
        $this->assertSame('Analyzing code with Eslint........................[Eslint FAILED]', $command->getErrorMessage());
    }
}
