## Recursively load PHP files in a directory

1. Iterator is an object that allows us to iterate through a series of items
2. The directory iterator can help us to automatically load our routes in a folder

## Laravel api routes best practices

1. Route group can help us to effectively organise our API routes
2. We can either use the array syntax or the method syntax to define a route group.
3. We can add URL prefix, route name prefix(name, as) , namespace and middleware to a route group
4. The where() method is useful to add matchng constraint to URL params.

## Controllers:

1. Controller is a function that runs when a HTTP request hits a route
2. We can delegate our route controllers into a dedicated Laravel Controller class.
3. There are 5 main methods in a controller class:
    - Index - displays a list of resources
    - Store - creates a new resources
    - Show - display a specific resources
    - Update- updates a specific resources
    - Destroy - deletes a specific resources
4. The resource/apiResources route helper method enables us to easily define API routes



## RESTful API Route Design and Laravel Routes

Architectural constraints: Rest defines *6 architectural constraints* which make any web service a true RESTFUL API.

1. Uniform interface
2. Client-server
3. Stateless
4. Cache able
5. Layered system
6. Code on demand(optional)

**Takeaways:**
1. Api routes typically refers to routes that return JSoN, while web routes are routes that return HTML pages
2. We define API routes in the api.php file, and web routes in web.php
3. Laravel uses the "substitute bindings middleware" to automagically load model instance to the controller 


## Seeding relationships

1. Laravel offers us factory helper functions like 
has() and for() to quickly generate relations for our models
2. We can use the sync method to generate many to many relation records(pivot table)

## Model:

Key topics in model:
1. Accessor(getter)
2. Mutator (setter)
3. Relationship
4. Casting

**Takeaways**
1. We use hasMany() and belongsTo() methods to define one to many relationship
2. BelongsToMany() is used to define many to many relationship. We use attach(), detach(), toggle(), and sync() to associate relations.
3.Accessors and mutators transform values when we retrieve/set model attributes.
4. Casting is used to cast a datatype to another while retrieving data i.e. cast to array automatically save as json and retrieve as an array. 

## SEEDS and Fatories:

1. Seeding is referred to populating the database with dummy data
2. Factory classes are used to generate fake models
3. We can use the db:seed Artisan command to trigger the seeders
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

