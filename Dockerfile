FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev libxml2-dev unzip \
    && docker-php-ext-install pdo_pgsql dom \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf

RUN printf 'expose_php=Off\nsession.use_strict_mode=1\nsession.use_only_cookies=1\n' > /usr/local/etc/php/conf.d/security.ini

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html/public/uploads \
    && chmod +x /var/www/html/bin/start.sh

COPY docker/apache.conf /etc/apache2/conf-available/oftalvista.conf
RUN a2enconf oftalvista

EXPOSE 80
CMD ["/var/www/html/bin/start.sh"]
