<?php

namespace Feek\LaravelGitHooks\Commands;

use Illuminate\Console\Command;

abstract class PHPCodeSnifferCommand extends Command
{
    /**
     * @return string
     */
    public function getCodingStandard()
    {
        return config('hooks.php-standard');
    }
}
