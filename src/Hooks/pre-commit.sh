#!/usr/bin/env bash
php artisan hooks:check-style

if [ ! $? -eq 0 ]; then
    echo "COMMIT REJECTED. Please ensure your code meets this projects styleguide. Automatically fix by running 'php artisan hooks:fix-style'."
    exit $?
fi

exit 0;
