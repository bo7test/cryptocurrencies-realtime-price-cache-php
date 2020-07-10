# Cryptocurrencies Realtime Price Cache Service

This service uses Binance Websocket API to cache prices into MySql database.

## Installation
```
composer install
```

## Run
```
php service.php &
```

We've used [this package](https://github.com/jaggedsoft/php-binance-api) to connect Binance API.
