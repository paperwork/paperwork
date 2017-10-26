#!/bin/bash

cat << EOF > /app/app/storage/config/database.json
{"driver":"mysql",
 "database":"$DB_ENV_MYSQL_DATABASE",
 "host":"$DB_PORT_3306_TCP_ADDR",
 "username":"$DB_ENV_MYSQL_USER",
 "password":"$DB_ENV_MYSQL_PASSWORD",
 "port":"$DB_PORT_3306_TCP_PORT"
}
EOF

# Ensure migration is performed and database is not empty.
if [[ ! -e migrated ]]; then
    # ensure MySQL docker container is up
    while ! mysqladmin ping -h "$DB_PORT_3306_TCP_ADDR" --silent; do
      echo "Waiting for MySQL container..."
      sleep 1
    done
    php artisan migrate
    touch migrated
fi

cat << EOF > /app/app/storage/config/paperwork.json
{"registration":"$PR_ALLOW_REGISTRATION",
 "forgot_password":"$PR_ALLOW_PASSWORD_RESET",
 "userAgentLanguage":"$PR_USER_AGENT_LANG",
 "showIssueReportingLink":"$PR_SHOW_REPORT_LINK"}
EOF

echo -n "8" > /app/app/storage/config/setup

# exec su-exec $UID:$GID /bin/s6-svscan /etc/s6.d
exec su-exec /bin/s6-svscan /etc/s6.d
