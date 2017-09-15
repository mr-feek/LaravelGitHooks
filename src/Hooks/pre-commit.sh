#!/usr/bin/env bash
php artisan hooks:pre-commit

if [ ! $? -eq 0 ]; then
    echo "COMMIT REJECTED."
    exit $?
fi

exit 0;
