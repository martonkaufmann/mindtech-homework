FROM php:8.4.12-cli-bookworm

EXPOSE 8000
EXPOSE 5173

ENV APP_ENV="development"

WORKDIR /var/www/html/homework

COPY . .

RUN curl -fsSL https://deb.nodesource.com/setup_24.x | bash -

RUN apt-get update &&\
    apt-get install -y git zip nodejs

RUN curl -o composer-setup.php -L https://raw.githubusercontent.com/composer/getcomposer.org/a5abae68b349213793dca4a1afcaada0ad11143b/web/installer &&\
    php composer-setup.php --version=2.8.11 &&\
    mv composer.phar /usr/local/bin/composer &&\
    rm composer-setup.php

#RUN docker-php-ext-install pcntl

#CMD ["composer", "run", "dev"]

CMD ["php", "artisan", "serve" , "--host=0.0.0.0"]
