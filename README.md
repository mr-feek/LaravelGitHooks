# LaravelGitHooks

[![Latest Stable Version](https://poser.pugx.org/mr-feek/laravel-git-hooks/v/stable)](https://packagist.org/packages/mr-feek/laravel-git-hooks)
[![Total Downloads](https://poser.pugx.org/mr-feek/laravel-git-hooks/downloads)](https://packagist.org/packages/mr-feek/laravel-git-hooks)
[![License](https://poser.pugx.org/mr-feek/laravel-git-hooks/license)](https://packagist.org/packages/mr-feek/laravel-git-hooks)

This package provides a means to add custom git hooks to your laravel project.

By default, this package ships with hooks for:
 - phpunit
 - phpcs
 - eslint
 
 Of course, these are customizable and you can easily create and register your own hooks to be run.


## Install

Via Composer

``` bash
$ composer require mr-feek/laravel-git-hooks
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
        'hooks:phpcs --diff',
        'hooks:eslint --diff --fix',
    ],
    'pre-push' => [
        'hooks:phpunit'
    ]
];
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Credits

- [Fiachra McDermott][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information
