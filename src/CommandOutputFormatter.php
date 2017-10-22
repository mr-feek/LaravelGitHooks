<?php

namespace Feek\LaravelGitHooks;

class CommandOutputFormatter
{
    /**
     * @param $message
     *
     * @return string
     */
    public function success($message)
    {
        return $this->pad($message) . ' [PASSED]';
    }

    /**
     * @param $message
     *
     * @return string
     */
    public function error($message)
    {
        return $this->pad($message) . ' [ERROR]';
    }

    /**
     * @param $message
     *
     * @return string
     */
    public function warn($message)
    {
        return $this->pad($message) . ' [WARNING]';
    }

    /**
     * @param $message
     *
     * @return string
     */
    protected function pad($message)
    {
        return str_pad($message, 50, '.');
    }
}
