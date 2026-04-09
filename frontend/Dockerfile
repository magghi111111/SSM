FROM php:8.2-apache

# Installa Python
RUN apt-get update && \
    apt-get install -y python3 python3-pip && \
    rm -rf /var/lib/apt/lists/*

# Copia il progetto
COPY . /var/www/html/

# Espone la porta
EXPOSE 8080

# Configura Apache per Cloud Run
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf