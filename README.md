# Laravel Git Hooks

<p align="center">
    
![Laravel Git Hooks](https://i.imgur.com/guHu5ep.png)

</p>

## This is a community project and not an "official" Laravel one
[![Latest Stable Version](https://poser.pugx.org/mr-feek/laravel-git-hooks/v/stable)](https://packagist.org/packages/mr-feek/laravel-git-hooks) 
[![Total Downloads](https://poser.pugx.org/mr-feek/laravel-git-hooks/downloads)](https://packagist.org/packages/mr-feek/laravel-git-hooks)
[![License](https://poser.pugx.org/mr-feek/laravel-git-hooks/license)](https://packagist.org/packages/mr-feek/laravel-git-hooks)
[![Build Status](https://travis-ci.org/mr-feek/LaravelGitHooks.svg?branch=master)](https://travis-ci.org/mr-feek/LaravelGitHooks)

This package provides a way to add custom git hooks to your laravel project. Easily configure any artisan command to be fired throughout the git-hook process. Want to ensure that all tests pass before a bad commit is pushed? Now's your chance!
 
Currently, the following git hooks are supported:
- pre-commit
- prepare-commit-msg
- pre-push
- post-checkout

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
- Register specific artisan commands to be run in the configuration array. For example, all commands nested within the `pre-commit` array key will be run prior to a git commit. All commands nested within the `pre-push` array key will be run prior to a git push. If any of these registered commands fail, then the git action will be prevented.

```php
<?php
return [
    'pre-commit' => [
        'hooks:phpcs --diff --proxiedArguments="-p -n --standard=PSR2"',
        'hooks:eslint --diff --proxiedArguments="--fix --quiet"',
    ],
    'pre-push' => [
        'hooks:phpunit'
    ],
    'post-checkout' => [
        'hooks:install-deps'
    ],
    'prepare-commit-msg' => [
        //
    ],
];
```

## Commands
This package ships with several handy artisan commands which work nicely as git hooks. The following commands come included:
- phpunit
- phpcs
- phpcbf
- phpstan 
    - If you are using this command, you will have a much better experience by creating a [custom phpstan.neon file](https://github.com/Weebly/phpstan-laravel)
- install dependencies (composer, yarn, npm)
- eslint

### Sniffer Commands
The `PHPCS`, `PHPCBF`, `PHPSTAN`, and `ESLINT` commands all allow you to pass arguments to the underlying process being executed. You
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

- [Fiachra McDermott](http://feek.rocks)
- [All Contributors](CONTRIBUTING.md)
- Fish hook icon originally provided by Carson Wittenberg.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information
