FROM php:8.3-fpm

WORKDIR /var/www

RUN apt update \
      && apt install -y apt-utils libpq-dev libpng-dev libzip-dev zip unzip git nano wget && \
      docker-php-ext-install pdo pdo_mysql mysqli && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

CMD ["php-fpm"]
