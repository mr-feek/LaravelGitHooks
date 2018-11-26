#!/usr/bin/env bash
php artisan hooks:commit-msg $1

STATUS_CODE=$?
if [ ! ${STATUS_CODE} -eq 0 ]; then
    exit ${STATUS_CODE}
fi

exit 0;
