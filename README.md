# LaravelGitHooks

[![Latest Stable Version](https://poser.pugx.org/mr-feek/laravel-git-hooks/v/stable)](https://packagist.org/packages/mr-feek/laravel-git-hooks)
[![Total Downloads](https://poser.pugx.org/mr-feek/laravel-git-hooks/downloads)](https://packagist.org/packages/mr-feek/laravel-git-hooks)
[![License](https://poser.pugx.org/mr-feek/laravel-git-hooks/license)](https://packagist.org/packages/mr-feek/laravel-git-hooks)

This package provides a means to add custom git hooks to your laravel project. Easily configure any artisan command to be fired throughout the git-hook process.

By default, this package ships with artisan commands for running:
- phpunit
- phpcs
- eslint
 
Currently, the following git hooks are supported:
- pre-commit
- prepare-commit-msg
- pre-push

Need one that isn't listed here? Feel free to open a PR!

## Install

Via Composer

``` bash
$ composer require mr-feek/laravel-git-hooks --dev
```

Edit your laravel project's `composer.json` so that these hooks are installed for every developer after they use composer.
```
"post-autoload-dump": [
    ...
    "@php artisan hooks:install"
]
```

## Configuration
- Publish this package's configuration file: `php artisan vendor:publish --provider="Feek\LaravelGitHooks\LaravelGitHooksServiceProvider"`
- Register specific commands to be run in the configuration array. For example, all commands nested within the `pre-commit` array key will be run prior to a git commit. All commands nested within the `pre-push` array key will be run prior to a git push. If any of these registered commands fail, then the git action will be prevented.

```php
<?php
return [
    'pre-commit' => [
        'hooks:phpcs --diff --proxiedArguments="-p -n --standard=PSR2"',
        'hooks:eslint --diff --proxiedArguments="--fix --quiet"',
    ],
    'pre-push' => [
        'hooks:phpunit'
    ]
];
```

## Sniffer Commands
The `PHPCS`, `PHPCBF`, and `ESLINT` commands all allow you to pass arguments to the underlying process being executed. You
can utilize this via the `--proxiedArguments` flag. In the code examples above, the following phpcs command will be executed: 
`phpcs -p -n --standard=PSR2`

## Supported Versions Of Laravel
Laravel ^5.5 is actively supported. Need support for earlier versions of Laravel? Feel free to open a PR

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

Wondering how to go about working on a laravel package? See http://laraveldaily.com/how-to-create-a-laravel-5-package-in-10-easy-steps/ and https://laravel.com/docs/5.5/packages

## Credits

- [Fiachra McDermott][http://feek.rocks]
- [All Contributors][CONTRIBUTING.md]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information
