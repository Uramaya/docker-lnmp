This is the docker file ofr creating hte Laravel(php), Nginx, Mysql environment.

■Clone this project's repository to your local
- git clone {{ url }}

■Move to your new download repository
- cd {{ New repository you just downloaded }}

■After making sure you have installed the Docker and start machine,
execute this command
- docker-compose up -d

■Enter to yur php container
- winpty docker exec -it {{ container }} bash

■copy .env.example as .env for laravel environment setting
- cp .env.example .env

■migrate your database
- php artisan migrate

■Generate your laravel key
- php artisan key:generate

■Search your docker machine(default) ip

docker-machine ip
In my case >192.168.99.100


■Open your browser and type 
・For Http
{{docker-machine ip}} ex, 192.168.99.100

・For Https(SSL)
https://{{docker-machine ip}} ex, https://192.168.99.100

If you cann see the website with Laravel BBS page, that means you are successful!
Good Luck!!


