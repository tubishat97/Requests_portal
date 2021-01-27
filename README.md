# Flight-tracker

## Installation

### Create your .env File
> you can copy and paste .env.example file ;)

### Install packages
```bash
$ composer install
```
or
```bash
$ composer install --ignore-platform-reqs
```

### Generate Application Key
```bash
$ php artisan key:generate
```

### Link storage
```bash
$ php artisan storage:link
```

### Give storage folder permission
```bash
$ chmod -R 777 storage/
```

### Migrate Database
```bash
$ php artisan migrate
```

### Seeding Database
```bash
php artisan db:seed
```