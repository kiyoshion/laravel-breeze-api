# Laravel breeze api

This repository provides api with laravel/breeze api.

## Create laravel project

```
composer create-project laravel/laravel laravel-breeze-api
php artisan serve
```

## Install laravel/breeze

```
composer require laravel/breeze --dev
php artisan breeze:install api
```

## Create database

```
CREATE DATABASE laravel_breeze_api;
CREATE USER 'laravel_breeze_api'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON laravel_breeze_api.* TO 'laravel_breeze_api'@'localhost';
```

Then migrate:

```
php artisan migrate
```

## Clone laravel/breeze-next repository

This repository is maintained by laravel team idk.

[https://github.com/laravel/breeze-next](https://github.com/laravel/breeze-next "https://github.com/laravel/breeze-next")

## Read its README
