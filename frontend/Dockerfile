FROM wonderfall/nginx-php:7.1
LABEL maintainer "Pierre Ugaz <pierre.ugazm@gmail.com>"

# Override default nginx conf
ADD ./deploy/paperwork.conf /nginx/sites-enabled/nginx.conf
ADD . /app

# Install packages
RUN apt add --no-cache \
    nodejs \
    nodejs-npm \
    git
    # DEBIAN_FRONTEND=noninteractive apt-get -y install supervisor pwgen && \

# Enable apache rewrite module
# Enable php mcrypt module
# Configure /app folder
# RUN a2enmod rewrite && php5enmod mcrypt && \
    # mkdir -p /app && rm -rf /var/www/html && ln -s /app/public /var/www/html

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
    chown -R $UID:$GID /app && chmod +x /app/docker-runner.sh

# Override environment to ensure laravel is running migrations.
RUN sed -i 's/return $app;//' /app/bootstrap/start.php
RUN echo '$env = $app->detectEnvironment(function() { return "development"; }); return $app;' >> /app/bootstrap/start.php

VOLUME ["/app/app/storage/"]

CMD ["/app/docker-runner.sh"]
