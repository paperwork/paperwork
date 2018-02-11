#!/bin/sh

if [[ -z $1 ]]
then
	echo "usage: $0 <http://kong-admin-url-here:port>"
	exit 1
fi

KONG_API_URL=$1

ls -1 ./migrations-api/[0-9]* | sort | while read THIS_MIGRATION_FULL
do
	THIS_MIGRATION=$(basename $THIS_MIGRATION_FULL)
	echo "Running $THIS_MIGRATION ..."
	/bin/sh "./migrations-api/$THIS_MIGRATION" "$KONG_API_URL"

	if [[ $? != 0 ]]
	then
		echo "Something unexpected happend. Please check \"$TMPDIR/migrations-api-$THIS_MIGRATION.log\" for more information. Aborting."
		exit 1
	fi
done

echo "Ran all."
exit 0
