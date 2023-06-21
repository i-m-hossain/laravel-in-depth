## SEEDS and Fatories:

## Database migration:

1. Migration is a concept of version control for database
2. Laravel will run migration files in chronological order ,i.e. by following the timestamp in the migration file name
3. The artisan console is a wonderful tool to generate boilerplate for our project

## docker mysql server access:
```
<!-- migration command using sail -->
/vendor/bin/sail down && /vendor/bin/sail up -d
/vendor/bin/sail artisan migrate

<!-- login inside docker mysql -->
docker exec -it <container id> bash 

> mysql -u <username(root)> -p
> password : password 
> show  databases;
> use docker_laravel(db name)
> show tables

<!-- restart all docker container -->
docker restart $(docker ps -q)

<!-- show all docker container** -->
#docker ps -a`

<!-- kill local sql server  -->
ps aux | grep mysql
sudo kill PID

    or 
sudo systemctl stop mysql 


<!-- kill local redis -->
sudo systemctl stop redis

```
## Facade

1. Facade allows us to call Service Instance method **statically**, providing us a convenient way to call Service method

2. You can think of **Facade** as the static counterpart of a service class


## Service Container and Service Provider

1. Service Providers are classes that instruct Laravel on how to instantiate a service/class

2. The **register()** method is where define our class binding

3. The **boot()** method is called after all services are registered.

4. We need to put our Service Provider in the **provider** array in the app config file to activate it. Otherwise Laravel will automatically resolve the Service on its own using the **Automatic Resolution** feature

##  Middleware and Http Kernel:
1. Middleware are functions that run before the request hits the router
2. The **handle()** method contains the main logic of the middleware, while the terminate() method contains the **clean up** logic just before the app is shut down.

3. The Kernel is responsible to pass the request to the router through middleware.

4. The Kernel bootstrap the application by setting up:
    1. Environment variable
    2. Configuration
    4. Exception handling
    5. Register facade and Service Provider


## Laravel's Architecture:

1. **/public/index.php** is the main entry file of a Laravel App

2. The service container is a giant box that keeps app services together. It allows the app to interact with the services.

3. The app needs to bind a service to the container before resolving it from the container

4. Singleton service can only have 1 instance

5. Kernel is the core of an app that does all the heavy work for us

