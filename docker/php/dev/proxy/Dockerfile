FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y \
        git \
        postgresql-client \
        libpq-dev \
        nano \
        librabbitmq-dev \
        libssh-dev \
        libzip-dev \
        zip \
        libicu-dev \
        poppler-utils \
    && apt-get clean \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
       zip \
       intl \
       pdo \
       pdo_pgsql \
       bcmath \
       opcache \
    && pecl install apcu \
    && pecl install amqp-1.11.0beta \
    && pecl install xdebug \
    && docker-php-ext-enable amqp \
    && docker-php-ext-enable apcu \
    && docker-php-ext-enable xdebug \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \

    && touch /usr/local/etc/php/conf.d/custom.ini \
    && echo "memory_limit=4096M;" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "realpath_cache_size=64M;" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "realpath_cache_ttl=7200;" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize=5000M;" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size=5000M;" >> /usr/local/etc/php/conf.d/custom.ini \

    && touch /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.enable=1;" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=0;" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=1;" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=300000;" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=512;" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_wasted_percentage=10;" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=64;" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.fast_shutdown=1;" >> /usr/local/etc/php/conf.d/opcache.ini \

    && touch /usr/local/etc/php/conf.d/apcu.ini \
    && echo "apc.enable=1;" >> /usr/local/etc/php/conf.d/apcu.ini \
    && echo "apc.enable_cli=0;" >> /usr/local/etc/php/conf.d/apcu.ini \
    && echo "apc.shm_size=256M;" >> /usr/local/etc/php/conf.d/apcu.ini \
    && echo "apc.mmap_file_mask=/tmp/apc.XXXXXX;" >> /usr/local/etc/php/conf.d/apcu.ini \

    && touch /usr/local/etc/php-fpm.conf \
    && echo "pm=ondemand" >> /usr/local/etc/php-fpm.conf \
    && echo "pm.max_children=100" >> /usr/local/etc/php-fpm.conf \
    && echo "pm.process_idle_timeout=10s" >> /usr/local/etc/php-fpm.conf \
    && echo "pm.max_requests=500" >> /usr/local/etc/php-fpm.conf \
    && echo "request_terminate_timeout=900s" >> /usr/local/etc/php-fpm.conf

# COPY ../config/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        git \
        libzip-dev \
        zlib1g-dev \
        unzip \
        python3 \
        pip \
        && ( \
            cd /tmp \
            && mkdir librdkafka \
            && cd librdkafka \
            && git clone https://github.com/edenhill/librdkafka.git . \
            && ./configure \
            && make \
            && make install \
        ) \
    && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) zip \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

RUN pip install moviepy \
    subprocess.run \
    path.py

RUN usermod -u 1000 www-data
# RUN chown -R 1000:historic /var/www/documents

WORKDIR /var/www/proxy/

RUN chown -R 1000:www-data /var/www/proxy
