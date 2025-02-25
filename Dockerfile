FROM devitools/hyperf:8.3

COPY . /opt/www

RUN composer install --prefer-dist --no-dev --optimize-autoloader
