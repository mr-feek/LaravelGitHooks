#!/usr/bin/env bash
php artisan hooks:pre-push

STATUS_CODE=$?
if [ ! ${STATUS_CODE} -eq 0 ]; then
    exit ${STATUS_CODE}
fi

exit 0;
