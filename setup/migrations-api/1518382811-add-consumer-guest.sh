#!/bin/sh

THIS_MIGRATION=$(basename $0)
KONG_API_URL=$1

STATUS_CODE=$(curl -X "POST" "$KONG_API_URL/consumers" \
     -H 'Content-Type: application/json; charset=utf-8' \
     -d $'{
  "custom_id": "00000000-0000-0000-0000-000000000000",
  "username": "00000000-0000-0000-0000-000000000000"
}' \
-s -w "%{http_code}" -o "$TMPDIR/migrations-api-$THIS_MIGRATION.log")

if [[ $STATUS_CODE == 200 || $STATUS_CODE == 409 ]]
then
	exit 0
else
	exit 1
fi
