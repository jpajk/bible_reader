FROM webdevops/php-nginx

RUN curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -

RUN apt-get install -y nodejs && \
	npm i -g less handlebars uglifyjs

ADD ./app/ /app/

WORKDIR /app/

RUN echo "create database symfony" | mysql --user=root --password=admin --host=172.17.0.2 && \
	mysql --host=172.17.0.2 --user=root --password=admin symfony < symfony.sql && \
	composer install &&  \
	php app/console assetic:dump --env=prod && \
	php app/console fos:elastica:populate && \
	chown -R application app/cache/ app/logs/

EXPOSE 8888