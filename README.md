## About Chat

Chat is a RealTime chat application. Build on Laravel 6.17 + Vue

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Installation

After clone you have to run: 

```bash
composer install
```
And:

```bash
npm install
```

This command installed necessary dependencies and libraries.
  
### Usage

Create database and configure .env file and generate application key:

```bash
php artisan key:generate
```

Run migrations. This create necessary tables in your database:

```bash
php artisan migrate
```

In addition, you can seed test rooms by:
```bush
php artisan db:seed
```  
or create rooms manually.

The application build on [Laravel WebSockets](https://github.com/beyondcode/laravel-websockets) and you can use the [official documentation](https://docs.beyondco.de/laravel-websockets/) configure .env or code below:

```bush
BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=sync

PUSHER_APP_ID=any-value
PUSHER_APP_KEY=any-value
PUSHER_APP_SECRET=any-value
``` 
*Chat use laravel-echo and pusher-js libraries, therefor you may fill pusher of any values like '111' or '123', it's doesn't matter. 

Install npm dependencies: 

```bash
npm install
```
And compile code to production:

```bush
npm run prod
```

Then you can register new user by registration form.
*Notice, you have to relate registered users in database `room_user` table.

Run web WebSockets:

```
php artisan websockets:serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
