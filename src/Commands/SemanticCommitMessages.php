<?php

namespace Feek\LaravelGitHooks\Commands;

use Feek\LaravelGitHooks\CommandOutputFormatter;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class SemanticCommitMessages extends BaseCommand
{
    const COMMIT_TYPES_ALLOWED = ['chore', 'docs', 'feat', 'fix', 'refactor', 'style', 'test'];

    /**
     * @inheritdoc
     */
    protected $signature = 'hooks:semantic-commits {file}';

    /**
     * @inheritdoc
     */
    protected $description = 'Enforces the usage of semantic commit messaging';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @var \Feek\LaravelGitHooks\CommandOutputFormatter
     */
    private $outputFormatter;

    public function __construct(Filesystem $filesystem, CommandOutputFormatter $outputFormatter)
    {
        $this->filesystem = $filesystem;

        parent::__construct();
        $this->outputFormatter = $outputFormatter;
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->info($this->outputFormatter->info('Checking semantics of commit message'));

        $commitMessageFile = $this->argument('file');
        $contents = $this->filesystem->get($commitMessageFile);

        // check if the commit message is already considered semantic

        foreach (self::COMMIT_TYPES_ALLOWED as $type) {
            if (Str::startsWith($contents, "$type: ")) {
                return 0;
            }
        }

        $this->error($this->outputFormatter->error('The proposed commit message is not considered semantic. Please prepend your commit message with one of the following: ' .
            implode(': ', self::COMMIT_TYPES_ALLOWED)));

        return 1;
    }
}
