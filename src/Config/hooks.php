<?php

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
    | Commands to run pre-commit
    |--------------------------------------------------------------------------
    |
    | Here is where you should list each artisan command that you want run
    | prior to a git commit. If any of these commands fail, then the
    | commit will fail. Add as many or few as you want.
    */
    'pre-commit' => [
        'hooks:phpcs --diff --proxiedArguments="-p -n --standard=PSR2"',
        'hooks:eslint --diff --proxiedArguments="--fix --quiet"',
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands to run prepare-commit-msg
    |--------------------------------------------------------------------------
    |
    | Here is where you should list each artisan command that you want run
    | prior to a git push. If any of these commands fail, then the
    | push will fail. Add as many or few as you want.
    */
    'prepare-commit-msg' => [],

    /*
    |--------------------------------------------------------------------------
    | Commands to run pre-push
    |--------------------------------------------------------------------------
    |
    | Here is where you should list each artisan command that you want run
    | prior to a git push. If any of these commands fail, then the
    | push will fail. Add as many or few as you want.
    */
    'pre-push' => [
        'hooks:phpunit'
    ],
];
