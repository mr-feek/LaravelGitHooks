<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

use Illuminate\Console\Command;

abstract class CommitHookCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (config($this->getConfigKey()) as $command) {
            $this->info('git hook invoking: ' . $command);
            $statusCode = $this->call($command);

            if ($statusCode !== 0) {
                return $statusCode;
            }
        }

        $this->info('git hook checks passed!');

        return 0;
    }

    /**
     * @return string
     */
    abstract function getConfigKey();
}
