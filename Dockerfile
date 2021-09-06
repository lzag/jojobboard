FROM ubuntu:21.04

SHELL ["/bin/bash", "-c"]

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update && \
    apt-get install -y \
    php7.4 \
    php7.4-dom \
    php7.4-soap \
    php7.4-curl \
    php7.4-xdebug \
    php7.4-mbstring \
    php7.4-zip \
    php7.4-mysql \
    curl \
    mariadb-client

RUN mkdir /jjb
COPY 000-default.conf /etc/apache2/sites-enabled/
RUN a2enmod rewrite && service apache2 restart

ENTRYPOINT ["/bin/bash"]
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

WORKDIR /jjb

EXPOSE 80
EXPOSE 443
