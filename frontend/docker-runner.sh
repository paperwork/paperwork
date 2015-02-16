#!/bin/bash

# Ensure migration is performed and database is not empty.
if [[ ! -e migrated ]]; then
    php artisan migrate

    touch migrated
fi

/run.sh
