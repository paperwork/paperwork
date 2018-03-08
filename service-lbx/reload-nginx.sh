#!/bin/sh

while ! wget http://service-discovery:8500
do
    echo "Consul not yet running - sleeping ..."
    sleep 3
done

# Render Nginx configuration template using values from Consul,
# but do not reload because Nginx has't started yet
preStart() {
    consul-template \
        -once \
        -consul service-discovery:8500 \
        -template "/etc/containerpilot/nginx.conf.ctmpl:/etc/nginx/nginx.conf"
}

# Render Nginx configuration template using values from Consul,
# then gracefully reload Nginx
onChange() {
    consul-template \
        -once \
        -consul service-discovery:8500 \
        -template "/etc/containerpilot/nginx.conf.ctmpl:/etc/nginx/nginx.conf:nginx -s reload"
}

until
    cmd=$1
    if [ -z "$cmd" ]; then
        onChange
    fi
    shift 1
    $cmd "$@"
    [ "$?" -ne 127 ]
do
    onChange
    exit
done
