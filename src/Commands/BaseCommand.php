<?php

namespace Feek\LaravelGitHooks\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    /**
     * Write a string as standard output.
     *
     * @param  string $string
     * @param  string $style
     * @param  null|int|string $verbosity
     * @param bool $prefix
     *
     * @return void
     */
    public function line($string, $style = null, $verbosity = null, $prefix = true)
    {
        if ($prefix) {
            $string = '[LARAVEL GIT HOOKS] ' . $string;
        }

        parent::line($string, $style, $verbosity);
    }
}
