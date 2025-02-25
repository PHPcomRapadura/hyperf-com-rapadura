FROM devitools/hyperf:8.3

ARG APP_TARGET="liv"
ENV APP_TARGET $APP_TARGET

COPY . /opt/www

COPY --from=devitools/hyperf:8.3 /devitools/.scripts/setup-target.sh /usr/local/bin/setup-target

RUN setup-target "$APP_TARGET"
