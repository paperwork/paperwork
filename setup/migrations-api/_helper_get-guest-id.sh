curl "$1/consumers/00000000-0000-0000-0000-000000000000" \
     -H 'Content-Type: application/json; charset=utf-8' \
     -s \
     | awk 'match($0, /"id":"[0-9a-z\-]+"/) { print substr( $0, RSTART, RLENGTH )}' \
     | awk -F: '{ print $2 }' \
     | sed 's/"//g'
