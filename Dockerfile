FROM webdevops/php-nginx

RUN curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -

RUN apt-get install -y nodejs && \
	npm i -g less handlebars uglifyjs

#COPY ./app /app/

ADD ./app/ /app/

WORKDIR /app/

RUN composer install &&  \
	php app/console assetic:dump --env=prod && \
	chown -R application app/cache/ app/logs/

EXPOSE 8888