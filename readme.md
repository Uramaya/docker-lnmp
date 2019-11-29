This is the docker file ofr creating hte Laravel(php), Nginx, Mysql environment.

■Clone this project's repository to your local
- git clone {{ url }}
  In this project url = "https://github.com/Uramaya/docker-lnmp.git"

■Move to your new download repository
- cd {{ New repository you just downloaded }}

■After making sure you have installed the Docker and start machine,
execute this command
※
If docker machine hasn't started, call this command first.
- docker-machine start

Then after make sure the Docker machine has started
- docker-compose up -d

■Check if the docker container is ready.
(If container is ready, the state shows "up")
- docker-compose ls

>              Name                            Command              State                    Ports
-------------------------------------------------------------------------------------------------------------------
dockerlnmptest_mysql-container_1   docker-entrypoint.sh mysqld     Up      0.0.0.0:3306->3306/tcp, 33060/tcp
dockerlnmptest_nginx-container_1   nginx -g daemon off;            Up      0.0.0.0:443->443/tcp, 0.0.0.0:80->80/tcp
dockerlnmptest_php-container_1     docker-php-entrypoint php-fpm   Up      9000/tcp



■Enter to yur php container
- winpty docker exec -it {{ container_name(Name)}} bash
Ex:winpty docker exec -it dockerlnmptest_php-container_1 bash

■copy .env.example as .env for laravel environment setting
- cp .env.example .env

■migrate your database
- php artisan migrate

■Generate your laravel key
- php artisan key:generate

■Search your docker machine(default) ip
- docker-machine ls
※docker-machine ip
　In my case >192.168.99.100


■Open your browser and type 
・For Http
{{docker-machine ip}} ex, 192.168.99.100

・For Https(SSL)
https://{{docker-machine ip}} ex, https://192.168.99.100

If you can see the website with Laravel BBS page, that means you are successful!
Good Luck!!


