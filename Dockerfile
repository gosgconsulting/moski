FROM wordpress:php8.2-apache

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install additional useful extensions
RUN docker-php-ext-install opcache

# Set recommended PHP settings
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
} > /usr/local/etc/php/conf.d/opcache-recommended.ini
