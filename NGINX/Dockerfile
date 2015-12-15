FROM nginx:1.9.8
#COPY htdocs /usr/share/nginx/html
RUN mkdir -p /usr/share/nginx/mysite
COPY htdocs /usr/share/nginx/mysite
RUN chmod -R 777 /usr/share/nginx/mysite
COPY nginx.conf /etc/nginx/nginx.conf
COPY mysite.conf /etc/nginx/conf.d/mysite.conf
