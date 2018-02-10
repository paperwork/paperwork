#!/bin/bash

set -e

host="$1"

until psql -h "$host" -U "postgres" -c '\q'; do
  >&2 echo "database-kong is unavailable - sleeping"
  sleep 1
done

>&2 echo "database-kong is up - executing command"

kong migrations up && /bin/containerpilot kong start kong start
