#!/usr/bin/env bash
php artisan hooks:post-checkout

STATUS_CODE=$?
if [ ! ${STATUS_CODE} -eq 0 ]; then
    exit ${STATUS_CODE}
fi

exit 0;
