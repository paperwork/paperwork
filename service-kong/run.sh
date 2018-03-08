#!/bin/sh

set -e

host="$1"

while ! wget http://service-discovery:8500
do
    echo "Consul not yet running - sleeping ..."
    sleep 3
done

until psql -h "$host" -U "postgres" -c '\q'; do
  >&2 echo "database-kong is unavailable - sleeping"
  sleep 1
done

>&2 echo "database-kong is up - executing command"

kong migrations up && /bin/containerpilot kong start kong start
