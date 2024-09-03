# Arcadia

## LAMP stack built with Docker Compose

A basic LAMP stack environment built using Docker Compose. It consists of the following:

- PHP
- Apache
- MySQL
- phpMyAdmin
- Redis

## Start project

```shell
docker compose up -d
// visit localhost
```

Your LAMP stack is now ready!! You can access it via `http://localhost`.

## Connect via SSH

You can connect to web server using `docker compose exec` command to perform various operation on it. Use below command to login to container via ssh.

```shell
docker compose exec webserver bash
```

## load database

```shell
docker compose down -v
rm -rf ./data/mysql/*
docker compose up -d --build
```

### Execute srcript from bash

```shell
docker compose exec database bash
mysql -p // mdp arcadia
USE arcadia
source /docker-entrypoint-initdb.d/init.sql
```

## phpMyAdmin

phpMyAdmin is configured to run on port 8080. Use following default credentials.

http://localhost:8080/  
username: root  
password: arcadia
