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

    /**
     * @return string
     */
    abstract function getCodeSnifferExecutable();

    /**
     * @return string
     */
    abstract function getErrorMessage();

    /**
     * @return string
     */
    abstract function getSuccessMessage();

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dirToCheckStyle = app_path();
        $executable = $this->getCodeSnifferExecutable();
        $standard = $this->getCodingStandard();

        exec(
            "$executable -p --standard=$standard $dirToCheckStyle",
            $output,
            $statusCode
        );

        if ($statusCode !== 0) {
            // todo: pretty!
            $this->alert(print_r($output, true));
            $this->error($this->getErrorMessage());
        } else {
            $this->info($this->getSuccessMessage());
        }

        return $statusCode;
    }
}
