This is the docker file ofr creating hte Laravel(php), Nginx, Mysql environment.

Å°Clone this project's repository to your local
- git clone {{ url }}

Å°Move to your new download repository
- cd {{ New repository you just downloaded }}

Å°After making sure you have installed the Docker and start machine,
execute this command
- docker-compose up -d

Å°Enter to yur php container
- winpty docker exec -it {{ container }} bash

Å°copy .env.example as .env for laravel environment setting
- cp .env.example .env

Å°migrate your database
- php artisan migrate

Å°Generate your laravel key
- php artisan key:generate

Å°Search your docker machine(default) ip 
docker-machine ip
In my case >192.168.99.100


Å°Open your browser and type 
ÅEFor Http
{{docker-machine ip}} ex, 192.168.99.100

ÅEFor Https(SSL)
https://{{docker-machine ip}} https://ex, 192.168.99.100

If you cann see the website with Laravel BBS page, that means you are successful!
Good Luck!!


