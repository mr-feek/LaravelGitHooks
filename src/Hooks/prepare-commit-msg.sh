#!/usr/bin/env bash
php artisan hooks:prepare-commit-msg

STATUS_CODE=$?
if [ ! ${STATUS_CODE} -eq 0 ]; then
    echo "COMMIT MESSAGE REJECTED: ${STATUS_CODE}"
    exit ${STATUS_CODE}
fi

exit 0;
