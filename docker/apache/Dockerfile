# docker/apache/Dockerfile
FROM httpd:2.4.51

COPY bartender.apache.conf /usr/local/apache2/conf/bartender.apache.conf

RUN echo "Include /usr/local/apache2/conf/bartender.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf
