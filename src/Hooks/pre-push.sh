#!/usr/bin/env bash
php artisan hooks:test

if [ ! $? -eq 0 ]; then
    echo "PUSH REJECTED. Your test suite is not currently passing"
    exit $?
fi

exit 0;
