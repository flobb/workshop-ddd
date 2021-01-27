FROM solune/symfony:7.4-apache

RUN buildDeps=" \
        librabbitmq-dev \
    " \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        $buildDeps \
        ssl-cert \
        librabbitmq4 \
    && docker-php-ext-install pdo_mysql \
    && pecl install xdebug amqp \
    && docker-php-ext-enable amqp \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false $buildDeps \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Apache conf
ADD vhost.conf /etc/apache2/sites-available/docker.conf
RUN mkdir -p /srv/public \
    && a2dissite 000-default \
    && a2ensite docker \
    && a2enmod ssl \
    && service apache2 restart

# PHP conf
COPY php.ini $PHP_INI_DIR/conf.d/z_app.ini

CMD ["apache2-foreground"]
