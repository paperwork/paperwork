FROM centurylink/apache-php:latest
MAINTAINER Derek Myers <arcticpro@gmail.com>

# Install packages
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get -y upgrade
RUN apt-get -y install supervisor pwgen mysql-client libmcrypt4 php5-mcrypt php5-json php5-curl php5-cli git-core curl build-essential openssl libssl-dev npm nodejs-legacy

# Override default apache conf
ADD ./deploy/apache.conf /etc/apache2/sites-enabled/000-default.conf

# Enable apache rewrite module
RUN a2enmod rewrite

# Enable php mcrypt module
RUN php5enmod mcrypt

# Configure /app folder
RUN mkdir -p /app && rm -fr /var/www/html

# Copy application + install dependencies
ADD . /app
RUN ln -s /app/public /var/www/html

WORKDIR /app
RUN composer self-update
RUN composer install
RUN npm install
RUN npm run gulp

# Fix permissions for apache
RUN chown -R www-data:www-data /app
