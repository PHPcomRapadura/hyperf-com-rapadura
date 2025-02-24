#!/usr/bin/env bash
set -e

if ! command -v apk &> /dev/null; then
  echo "Error: 'apk' not found. Make sure you are running this script in an Alpine Linux environment." >&2
  exit 1
fi

if ! command -v composer &> /dev/null; then
  echo "Error: 'composer' not found. Make sure it is installed and accessible in the system PATH." >&2
  exit 1
fi

echo "[$1] Installing PHP extensions and dependencies"

if [ "$1" = "dev" ]; then
  cd /etc/php*

  {
    echo "opcache.enable=0"
    echo "opcache.interned_strings_buffer=72"
  } >> conf.d/99_php.ini

  apk add php83-pecl-xdebug php83-pecl-pcov
  {
    echo "xdebug.mode=develop,debug,coverage"
    echo "xdebug.idekey=PHPSTORM"
  } >> conf.d/50_xdebug.ini
else
  composer install --prefer-dist --no-dev --optimize-autoloader
fi
