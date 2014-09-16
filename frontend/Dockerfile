FROM centurylink/apache-php:latest
MAINTAINER Derek Myers <arcticpro@gmail.com>

# Install packages
RUN apt-get update && \
 DEBIAN_FRONTEND=noninteractive apt-get -y upgrade && \
 DEBIAN_FRONTEND=noninteractive apt-get -y install supervisor pwgen && \
 apt-get -y install mysql-client libmcrypt4 php5-mcrypt php5-json php5-curl php5-cli

# Override default apache conf
ADD ./deploy/apache.conf /etc/apache2/sites-enabled/000-default.conf

# Enable apache rewrite module
RUN a2enmod rewrite

# Enable php mcrypt module
RUN php5enmod mcrypt

# Configure /app folder
RUN mkdir -p /app && rm -fr /var/www/html && ln -s /app/public /var/www/html

# Copy application + install dependencies
ADD . /app
WORKDIR /app
RUN composer install

# Fix permissions for apache
RUN chown -R www-data:www-data /app
