FROM centurylink/apache-php:latest
MAINTAINER Derek Myers <arcticpro@gmail.com>

# Install packages
RUN apt-get update && \
 DEBIAN_FRONTEND=noninteractive apt-get -y upgrade && \
 DEBIAN_FRONTEND=noninteractive apt-get -y install supervisor pwgen && \
 apt-get -y install mysql-client libmcrypt4 php5-mcrypt php5-json php5-curl \
 php5-ldap php5-cli nodejs nodejs-legacy npm git git-core

# Override default apache conf
ADD ./deploy/apache.conf /etc/apache2/sites-enabled/000-default.conf

# Enable apache rewrite module
# Enable php mcrypt module
# Configure /app folder
RUN a2enmod rewrite && php5enmod mcrypt && \
    mkdir -p /app && rm -rf /var/www/html && ln -s /app/public /var/www/html

# Copy application + install dependencies
ADD . /app
WORKDIR /app

RUN \
    # Allow writing access into cache storage
    find ./app/storage -type d -print0 | xargs -0 chmod 0755 && \
    find ./app/storage -type f -print0 | xargs -0 chmod 0644 && \
    # Install dependencies and build the scripts and styles
    composer install && npm update && npm install && \
    npm install -g gulp bower && bower --allow-root install && gulp && \
    # Fix permissions for apache \
    chown -R www-data:www-data /app && chmod +x /app/docker-runner.sh

# Override environment to ensure laravel is running migrations.
RUN sed -i 's/return $app;//' /app/bootstrap/start.php
RUN echo '$env = $app->detectEnvironment(function() { return "development"; }); return $app;' >> /app/bootstrap/start.php

CMD ["/app/docker-runner.sh"]
