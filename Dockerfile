FROM php:8.2-cli

WORKDIR /app

# installa python se ti serve
RUN apt-get update && \
    apt-get install -y python3 python3-pip && \
    rm -rf /var/lib/apt/lists/*

COPY . .

# avvia server PHP sulla porta dinamica
CMD php -S 0.0.0.0:$PORT