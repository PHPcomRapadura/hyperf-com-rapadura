FROM hyperf/hyperf:8.3-alpine-v3.19-swoole

##
# ---------- env settings ----------
##
ARG timezone

ARG APP_ENV="liv"
ENV APP_ENV $APP_ENV
ENV STDOUT_LOG_LEVEL=alert,critical,emergency,error,warning
ENV TIMEZONE=${timezone:-"UTC"} \
    SCAN_CACHEABLE=(true)

WORKDIR /opt/www

COPY . /opt/www

# update
RUN set -ex \
    # ---------- print some stuff -----
    && php -v && php -m && php --ri swoole \
    # ---------- apply settings -------
    && /opt/www/.docker/app/default.sh "$TIMEZONE" \
    && /opt/www/.docker/app/conditional.sh "$APP_ENV" \
    # ---------- clear works ----------
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

EXPOSE 9501

ENTRYPOINT [ "php", "/opt/www/bin/hyperf.php" ]

CMD [ "start" ]
