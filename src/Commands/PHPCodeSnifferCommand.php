<?php

namespace Feek\LaravelGitHooks\Commands;

abstract class PHPCodeSnifferCommand extends SnifferCommand
{
    /**
     * @return string
     */
    public function getCodingStandard()
    {
        return config('hooks.php-standard');
    }

    public function getFileExtension()
    {
        return 'php';
    }

    public function getFileLocation()
    {
        return app_path();
    }

    public function getAdditionalFlags()
    {
        $standard = $this->getCodingStandard();
        return "-p --standard=$standard";
    }
}
