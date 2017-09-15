# LaravelGitHooks

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package provides a means to add custom git hooks to your laravel project.

By default, this package ships with hooks for:
 - phpunit
 - phpcs. 
 
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
        'hooks:check-style',
    ],
    'pre-push' => [
        'hooks:test'
    ]
];
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email feek@feek.rocks instead of using the issue tracker.

## Credits

- [Fiachra McDermott][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mr-feek/LaravelGitHooks.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/mr-feek/LaravelGitHooks/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/mr-feek/LaravelGitHooks.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/mr-feek/LaravelGitHooks.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mr-feek/LaravelGitHooks.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mr-feek/LaravelGitHooks
[link-travis]: https://travis-ci.org/mr-feek/LaravelGitHooks
[link-scrutinizer]: https://scrutinizer-ci.com/g/mr-feek/LaravelGitHooks/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/mr-feek/LaravelGitHooks
[link-downloads]: https://packagist.org/packages/mr-feek/LaravelGitHooks
[link-author]: https://github.com/mr-feek
[link-contributors]: ../../contributors
