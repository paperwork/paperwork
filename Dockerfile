FROM klud/nginx-php:5.6
LABEL maintainer "Pierre Ugaz <pierre.ugazm@gmail.com>"

ENV UID=991 \
    GID=991

# Override default nginx conf
ADD https://getcomposer.org/download/1.4.2/composer.phar /usr/local/bin/composer
ADD docker/ /
ADD frontend/ /app

# Grant execution permission on composer
RUN chmod +x /usr/local/bin/composer && \
    # Install packages
    apk add --no-cache \
    bash \
    nodejs \
    nodejs-npm \
    git \
    # Mysql client because it installs mysqladmin which is needed
    # In order to wait and connect with mysql/mariadb container
    mysql-client

# Copy application + install dependencies
# ADD . /app
WORKDIR /app

RUN \
    # Allow writing access into cache storage
    find ./app/storage -type d -print0 | xargs -0 chmod 0755 && \
    find ./app/storage -type f -print0 | xargs -0 chmod 0644 && \
    # Install dependencies and build the scripts and styles
    composer install && npm update && npm install && \
    npm install -g gulp bower && bower --allow-root install && gulp && \
    # Fix permissions for apache \
    chown -R $UID:$GID /app && chmod +x /usr/local/bin/docker-runner.sh

# Override environment to ensure laravel is running migrations.
RUN sed -i 's/return $app;//' /app/bootstrap/start.php
RUN echo '$env = $app->detectEnvironment(function() { return "development"; }); return $app;' >> /app/bootstrap/start.php

EXPOSE 8888
VOLUME ["/app/app/storage/"]
CMD ["/usr/local/bin/docker-runner.sh"]
