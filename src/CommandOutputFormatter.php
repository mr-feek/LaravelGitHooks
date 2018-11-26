<?php

namespace Feek\LaravelGitHooks;

class CommandOutputFormatter
{
    /**
     * @param string $message
     *
     * @return string
     */
    public function success($message)
    {
        return $this->pad($message) . ' [PASSED]';
    }

    /**
     * @param string $message
     *
     * @return string
     */
    public function error($message)
    {
        return $this->pad($message) . ' [ERROR]';
    }

    /**
     * @param string $message
     *
     * @return string
     */
    public function warn($message)
    {
        return $this->pad($message) . ' [WARNING]';
    }

    /**
     * @param string $message
     *
     * @return string
     */
    public function info($message)
    {
        return $this->pad($message) . ' [INFO]';
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function pad($message)
    {
        return str_pad($message, 50, '.');
    }
}
