<?php

return [
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
        'hooks:check-style',
    ],

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
        'hooks:test'
    ]
];
