#!/usr/bin/env bash
php artisan hooks:pre-commit

STATUS_CODE=$?
if [ ! ${STATUS_CODE} -eq 0 ]; then
    echo "COMMIT REJECTED: ${STATUS_CODE}"
    exit ${STATUS_CODE}
fi

exit 0;
