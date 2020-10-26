# Armory

This is a work in progress type project. Getting myself reacclimated to Laravel and PHP as a whole. It is an exercise in using an pre-existing external API and create table seeders to populate a large amount of static data within a Mysql DB.

## Getting Started

_(notes for myself of course, cause I'm old)_

- clone the repo

```shell
git clone https://github.com/unisys12/armory.git
```

- cd into the repo

```shell
cd armory
```

- run composer

```shell
composer install
```

- adjust your .env settings

```shell
# APP CHANGES
APP_NAME=Armory
APP_URL=http://armory.test

# BUNGIE X-API-KEY (Required)
BUNGIE_KEY=xxxxxxxxxxxxxxxx

# LOCAL DATABASE SETTINGS
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=armory
DB_USERNAME=homestead
DB_PASSWORD=secret
```

- run the migrations & seeders

```shell
php artisan migrate --seed
```

## How it Works _(currently)_

### Populating the Manifest

I am making use of the `Illuminate\Support\Facades\Http` Facade to make a HTTPS request to the Bungie API Manifest Endpoint, which is currently `/Destiny2/Manifest/`. I then parse the JSON response to pick out the properties that we might want and store them in a very rough key, value type store in MySQL.

### Populating Items and Collections

After making a query to the Manifest table for the DestinyInventoryItemDefinition component path, the resulting JSON response is parsed an inserted into the items table.

Each of the seeder classes work in a similar fashion.

## TO DO

I've actually achieved what I set out for this project. Although only at a proof of concept level. But I would like to add a few quality of life things to it, such as -

- Create relationships between the tables.
- Scheduled Task to check for weekly updates to the Manifest, then reseed.
- Updates Catalog - When updates are applied, new items and such are added. I would like to track those and store those changes in a separate table.
