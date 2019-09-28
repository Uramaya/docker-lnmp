FROM nginx:latest
COPY nginx/laravel.conf /etc/nginx/conf.d/default.conf
COPY nginx/ssl/server.crt /etc/nginx/server.crt
COPY nginx/ssl/server.key /etc/nginx/server.key

WORKDIR /etc/nginx
RUN chmod 400 /etc/nginx/server.crt
RUN chown root:root /etc/nginx/server.crt
CMD ["nginx", "-g", "daemon off;"]