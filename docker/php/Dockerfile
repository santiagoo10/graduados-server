FROM php:7.4.6-fpm

ARG UID
EXPOSE $UID

RUN adduser -u ${UID} --disabled-password --gecos "" appuser
#para almacenar claves privadas, para repos privados
RUN mkdir /home/appuser/.ssh
RUN chown -R appuser:appuser /home/appuser/

#no pregunta si queremos añadir conf para repos privados
RUN echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config
#conf de la console
RUN echo "export COLUMNS=300" >> /home/appuser/.bashrc
#sf ejecuta bin/console.
RUN echo "alias sf=/appdata/www/bin/console" >> /home/appuser/.bashrc

COPY ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
    && apt-get install -y git acl openssl openssh-client wget zip vim librabbitmq-dev libssh-dev \
    && apt-get install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip gd soap bcmath sockets \
    && pecl install xdebug amqp \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache amqp xdebug

#instalar compose
RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update

#linters
RUN wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer

RUN mkdir -p /appdata/www

#optmiza dependecias de composer
#USER appuser
#RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative \
	#&& composer clear-cache

WORKDIR /appdata/www
