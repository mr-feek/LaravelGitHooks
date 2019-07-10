<?php declare(strict_types=1);

namespace Feek\LaravelGitHooks;

/**
 * @internal
 */
class CommandOutputFormatter
{
    public function success(string $message): string
    {
        return $this->pad($message) . ' [PASSED]';
    }

    public function error(string $message): string
    {
        return $this->pad($message) . ' [ERROR]';
    }

    public function warn(string $message): string
    {
        return $this->pad($message) . ' [WARNING]';
    }

    public function info(string $message): string
    {
        return $this->pad($message) . ' [INFO]';
    }

    protected function pad(string $message): string
    {
        return str_pad($message, 50, '.');
    }
}
