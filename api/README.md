# Yaakov Bank - API

## Installation

Install project dependencies using composer

```
composer install
```

Configure o autoload

```
composer dump-autoload
```

## Configurations

Copy the structure of the example .env variables file

```
cp .env.example .env
```

Then

```
php artisan key:generate
```

Configure bank access credentials

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Generate database

```
php artisan migrate
```

Generate ADM user

```data
php artisan db:seed
```

ADMIN name = adm
ADMIN password = pass

## Execution

Run project

```data
php artisan serve
```

To create common users (password=1111) using the factory just run the following command

```data
php artisan db:seed --class=UserFakeTableSeeder
```

## Testing

Run project

```data
php artisan test
```

## Patterns and Rules

**Coding Style**

[PSR-2](http://www.php-fig.org/psr/psr-2/)

**Division of layers and responsibility**

```
Controller -> Service -> Repository -> Model
```
