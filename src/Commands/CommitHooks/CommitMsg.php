<?php

namespace Feek\LaravelGitHooks\Commands\CommitHooks;

class CommitMsg extends CommitHookCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks:commit-msg
                            {file : the file containing the contents of the proposed commit message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoked within git commit-msg hook';

    /**
     * @return string
     */
    protected function getConfigKey()
    {
        return 'hooks.commit-msg';
    }

    /**
     * @inheritdoc
     */
    public function buildArgumentArrayFromArgumentString($commandName, $arguments = '')
    {
        // the explicit arguments passed to be passed to the underlying command to be invoked
        $arguments = parent::buildArgumentArrayFromArgumentString($commandName, $arguments);

        // the commit message file contents will be put onto the top of this stack for the underlying command to access
        return $arguments + [
            'file' => $this->argument('file'),
        ];
    }
}