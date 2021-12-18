FROM php:8.0-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

# Naturally alpine comes with a built in cron, I'm going to be tapping into this in order for making
# a simplisitc scheduler for executing jobs every two minutes to insert a fake-style event stream in an automated
# fashion.
COPY ./cron/crontab /etc/crontabs/root
