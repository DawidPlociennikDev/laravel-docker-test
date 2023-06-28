
## Start project

To run the project, run the following commands

* install dependencies and libraries
```
  composer install
```

* build docker
```
  docker-compose build app
```

* run docker enviroment
```
docker-compose up -d
```

* enter project [http://localhost:8000](http://localhost:8000)


* phpMyAdmin [http://localhost:8080](http://localhost:8080)

* seed database
```
docker-compose exec app php artisan migrate --seed
```

* use docker composer for php artisan commands
```
docker-compose exec app <your-command>
```

## Testing
* run test
```
docker-compose php artisan test
```

## TODO
* portfolio
* shortly docker-compose commands
