#!/usr/bin/env bash
php artisan hooks:pre-push

if [ ! $? -eq 0 ]; then
    echo "PUSH REJECTED."
    exit $?
fi

exit 0;
