# Microservices Backend Developer Test
Photos CRUD, Like and Login

## Installation

After cloning this repo, go to the aplication root folder and run composer install
```
$ composer install
```

edit your `.env` file, if not exist just copy it from `.env.example`

```
APP_NAME="Photos Test"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
DB_TIMEZONE=+07:00

CACHE_DRIVER=file
QUEUE_CONNECTION=sync

#for jwt secret
JWT_SECRET=

#This for disk image
MEDIA_DISK=media
```

generate aplication secret key
```
$ php artisan key:generate
```

generate jwt secret key
```
$ php artisan jwt:secret
```

now run migration
```
$ php artisan migrate
```

run database seeder for user and tags
```
$ php artisan db:seed
```

make sure your Microservices is running
```
$ php artisan serve
```

Login
```
email : pamungkas.rizall@gmail.com
password : 123456
```

## List API
import file collection and enviroment in the root folder
```
collection : Vhiweb.postman_collection.json
enviroment : vhiweb.postman_environment.json
```
