FROM nginx:stable-alpine

# Add this file under container, it's equal to the followings that can be define docker-compose.yaml like this
# Volumes:
#  - ./docker/ngnix.conf:/etc/nginx/conf.d/default.conf
#ADD docker/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /etc/nginx/conf.d

COPY docker/nginx.conf .

#RUN mv nginx.conf default.conf

WORKDIR /var/www/html

COPY . /var/www/html

COPY docker/php.ini /usr/local/etc/php/
#COPY src .


