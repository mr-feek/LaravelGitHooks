<?php declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Git Hooks Enabled
    |--------------------------------------------------------------------------
    |
    | Whether or not to run these sweet, sweet git hooks. You probably want
    | these disabled on your build servers, etc.
    |
    */
    'enabled' => env('GIT_HOOKS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Commands to run during commit-msg
    |--------------------------------------------------------------------------
    |
    | Here is where you should list each command that you want run
    | during the commit message hook. If any of these commands fail, then
    | the commit will be aborted. The commit message file location will
    | automatically be passed as the first argument to all commands
    | listed here.
    */
    'commit-msg' => [
       //
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands to run pre-commit
    |--------------------------------------------------------------------------
    |
    | Here is where you should list each command that you want run
    | prior to a git commit. If any of these commands fail, then the
    | commit will fail. Add as many or few as you want.
    */
    'pre-commit' => [
        'php artisan hooks:phpcs --diff --proxiedArguments="-p -n --standard=PSR2"',
        'php artisan hooks:phpstan --diff --proxiedArguments="-c phpstan.neon -l 0"',
        'php artisan hooks:eslint --diff --proxiedArguments="--fix --quiet"',
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands to run prepare-commit-msg
    |--------------------------------------------------------------------------
    |
    | Here is where you should list each command that you want run
    | while preparing the commit msg. If any of these commands fail, then
    | the commit will be aborted. The commit message file location will
    | automatically be passed as the first argument to all commands
    | listed here. Additionally, the two optional arguments will be
    | passed as arguments if they are included.
    */
    'prepare-commit-msg' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands to run pre-push
    |--------------------------------------------------------------------------
    |
    | Here is where you should list each command that you want run
    | prior to a git push. If any of these commands fail, then the
    | push will fail. Add as many or few as you want. The commit
    | hook arguments will automatically be proxied to these commands
    | if they are provided.
    */
    'pre-push' => [
        './vendor/bin/phpunit',
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands to run post-checkout
    |--------------------------------------------------------------------------
    |
    | Here is where you should list each command that you want run
    | after git checkout (also invoked on git clone). This hook cannot affect
    | the outcome of git checkout. Add as many or few as you want. The commit
    | hook arguments will automatically be proxied to these commands
    | if they are provided.
    */
    'post-checkout' => [
        'php artisan hooks:install-deps',
    ],
];
