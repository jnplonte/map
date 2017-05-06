# GOOGLE MAP API


## Dependencies
* laravel: [https://laravel.com/](https://laravel.com/)
* php: [https://php.net/](https://php.net/)
* mysql: [https://mysql.com/](https://mysql.com/)
* composer: [https://getcomposer.org/](https://getcomposer.org/)
* phpunit: [https://phpunit.de/](https://phpunit.de/)


## Installation
* change permission of {root}\api\bootstrap and {root}\api\storage by running `chmod 777 -R bootstrap storage`
* install dependencies by running `composer install`
* rename `.env-sample` to `.env` and change db configurations
* get database and mock data by running `php artisan migrate:refresh --seed`


## How to Use
#### add map information
- **[POST]** `/route`
- required parameters : `[["ROUTE_START_LATITUDE", "ROUTE_START_LONGITUDE"],	["DROPOFF_LATITUDE_#1", "DROPOFF_LONGITUDE_#1"]]`
- sample parameters : `param : [["22.3061093","114.1716293"],["22.3013212","114.1704476"],["22.304309","114.171990"]]`


#### get map information
- **[GET]** `/route/{token}`
- sample token : `832219bfa054d5a9257dfc1470dced6d`

## Testing
* install phpunit by following this instruction [https://phpunit.de/getting-started.html](https://phpunit.de/getting-started.html)
* go to root directory
* run unit test by running `phpunit`
* *note: test is inside {root}/api/tests/*
