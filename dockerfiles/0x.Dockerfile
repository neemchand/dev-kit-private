FROM devopsfnl/image:php-8.2.11

COPY php.ini /usr/local/etc/php/

ENTRYPOINT ["/var/www/html/dockerfiles/api-runner"]
