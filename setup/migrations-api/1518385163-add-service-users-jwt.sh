#!/bin/sh

THIS_MIGRATION=$(basename $0)
KONG_API_URL=$1

CONSUMER_GUEST=$(./migrations-api/_helper_get-guest-id.sh $KONG_API_URL)

STATUS_CODE=$(curl -X "POST" "$KONG_API_URL/apis/service-users/plugins" \
     -H 'Content-Type: application/json; charset=utf-8' \
     -d $'{
  "name": "jwt",
  "config.anonymous": "'"$CONSUMER_GUEST"'",
  "config.claims_to_verify": [
    "exp",
    "nbf"
  ]
}' \
-s -w "%{http_code}" -o "$TMPDIR/migrations-api-$THIS_MIGRATION.log")

if [[ $STATUS_CODE == 200 || $STATUS_CODE == 409 ]]
then
	exit 0
else
	exit 1
fi
