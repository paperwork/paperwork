#!/bin/sh

set -e

host="$1"

until psql -h "$host" -U "postgres" -c '\q'; do
  >&2 echo "database-kong is unavailable - sleeping"
  sleep 1
done

>&2 echo "database-kong is up - executing command"

/bin/containerpilot node --harmony /app/compiled/Server.js
