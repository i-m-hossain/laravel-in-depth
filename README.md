## Laravel Whisper
- Http is rather slow for real time application. It is quicker to communicate with the server through websocket connection.
- Whisper() allows us to send events to each other without passing through Laravel server.
- ListenToWhisper() listens to peer events in the channel

## Private and Presence Channel:
- Private and Presence channel will `only allow authenticated user to join in`. They use the `default auth guards` to authenticate users.
- Presence channel keeps track of all the `subscribing client`s while private channel doesn't.
- We use `Echo.private()` for private channels and `Echo.join()` for presence channels.
- We need to define an `authorization callback` in channels.php for `private` and `presence channel`
- Private channel auth callback should return `boolean`, while presence should return the `authenticated user` instance.
## Laravel Echo & WebSockets 
-` Echo is the official client JS library` for us to subscribe and reeive websocket events from the server
- Vite compiles js code and gives a fluent user experience
- `Echo.channel()` allows us to subscribe to a websocket channel
- `Echo.subscribed()` lets us to define a callback that will be triggered when we have successfully subscribed to a channel
- We use `listen()` to listen to websocket events
- We should use a `'.' prefix` when we want to listen to custom event in Echo.

## Broadcasting event and websocket channels:
- If a client wants to subscribe to a websocket channel in laravel, the client will first perform a `'HTTP handshake'`, i.e. to authenticate the user before establishing a persisted websocket connection
- Event classes will need to implement the `ShouldBroadcast` interface before Laravel can broadcast them to the websocket
- We need to configure the `host and port` of the Pusher driver in `broadcasting.php` config file to get laravel to use our self-hosted Laravel Websocket server.
- By default, Laravel will use the Event FQCN(Fully qualified class name) as the event name. We can customise this by defining `broadcastAs()`.
- `BroadcastWith()` is a way for us to attach data in the event payload.


## WebSocket Broadcasting setup and config:
- `Pusher, Ably, Laravel Webscokcets, Socketi and Laravel Echo server` are websocket servers that are supported by Laravel
- Laravel websocket is a wonderful open-source drop in replacement for pusher.
- Laravel uses the `PubSub websocket pattern` to publish real-time app events.
- We need to setup a `queue driver` for laravel to broadcast websocket events.
-The `BroadcastServiceProvider` should be enabled in the app config
- Laravel Websockets exposed a `debugging dashboard` for our websocket connections
## Websockets
- Websocket(WS) is a communication protocol to transmit data between computers, where it is commonly used is realtime apps
- In contrast to HTTP, `WS persists and maintain its connection with server`, so the subsequent data transmission will be lightning fast
- There are two common WS app pattersns`PubSub` and `RPC(Remote procedure calls)`
- `Pubsub involves 1 server` that broadcasts messages to multiple clients. Commonly seen in financial app where there is a need to stream realtime data.
- RPC is very similar to http where the client will send a request and expects a reply fromo the server. RPC can be used in messaging apps.

## Notification
- Laravel provides us a variety of drivers to send out notifications to our users, including `mail, database, broadcast, slack and vonage`.
- There are many more community-maintained drivers, eg telegram, discord etc.
- `php artisan make:notification` will generate the boilerplate to create a new notification class.
- We can use `Notification::send()` or `$notifiable->notify()` to send out notification.

## creating temporary link:
- We can use `signed routes` to protect our routes from unwanted modification
- We use `URL::temporarySignedRoute()` to create a link with expiration, while `URL::signRoute` to create a permanent protected link
- Laravel uses salted `sha256` to hash the route as a measure to prevent modification
## I18N:
- Internationalisation or `i18n` is the notion of providing translation to different locale.
- We can use the `__()` or `Lang::get()` to retrieve translations from the language file.
- Laravel puts all the translation files in the `lang directory.`
- We can choose to write our translation files in either `php or json` file format
- `trans_choice` is a helper function for to handle pluralization
## Laravel testing
- Laravel provides us a convenient `actingAs()` method to login as any given user
- `setUp()` is a handy special function that runs `before every test function`
- `teardown()` is the opposite setup(). teardown() runs `after every test function.`
- actingAs() accepts a `second argument` where we can specify which `auth guard` that we want to use.

## Sanctum
- Sanctum offers `cookie based` authentication and `token based` authentication
- Token is simple to setup and use but can be dangerous if it is stolen
- Cookie is harder to setup, but it will protect our app from `CSRF and XSS attacks`
- Cookie based authentication is `sensitive to domain names`, be sure to configure Sanctum before

## customizing email verification
- Laravel fortify relies on the build in `VerifyEmail` class provided by Laravel to send out verification email
- We call `VerifyEmail::toMailUsing()` to define our own logic to send out the verification notification
- We can encode information into Laravel's signed route for validation in the future

## 2FA
- The User model needs to use the `TwoFactorAuthenticatable` trait in order for 2FA work properly
- The `confirmPassword` option will force the user to confirm their password when setting up 2FA.
- Laravel will issue the user a new set of recovery codes if they log in via `recovery code`.

## Laravel Fortify: Email Verification
- Fortify provides us a handy email verification feature to confirm the user's email address
- We can use the '`verify`' middleware to protect our app's routes.
- We will need to implement the `MustVeryfyEmail` interface to our user model for email validation to work.

## Laravel Fortify: Auth, Registration and password reset
- Laravel protects all its web routes from `CSRF attacks` by default
- We need `Laravel Sanctum` if we want to protect our api routes from CSRF attacks
- We can use Fortify Action classes to customize the user registration logic along with other actions
- Password reset requires a GET route with a route name of '`password.reset`' in order to work properly

## Authentication
- Laravel fortify is a package that takes care o most authentication logic for us.
- Fortify provides us several features out of the box, namely:
    1. Registration
    2. Login 
    3. Reset password
    4. Email Verification
    5. Update Profile Information
    6. Update Password
    7. 2 factor authentication
- Fortify also enables us to rate limit the login routes
## Throttle and Rate limiting
- `Throttle` means to limit the number of opearations in a given period of time
- The `throttle middleware` in laravel helps to mitigate the `DOS(Denial of Service)` attacks from malicious user
- We can define `named rate limiter` in `RouteServiceProvider` Class
- We can pass in the rate limiting config `directly` to the throttle middleware if we prefer not to use the named Rate Limiter

## Generating api docs with scribe
- `Scribe` is an amazing package that helps us to generate api documentation in a beautiful webpage
- We use the '@' directive in phpdocs to provide details about our API endpoints
## Config
- `config()` is a handy helper function to access configuration values from the config folder
- We use the `.(dot) notation` to access the configuration
- `env()` is a helper function to access the environment variable
## Laravel IDE helper
- Laravel uses a lot of facades and magic methods that are not IDE friendly
- The IDE helper package solves this issue by generating an 'ide_helper.php' file to aid the autocompletion

## Custom validation with validator
- Validator is an alternative way to validate input data other than using the Request class
- Validator has the benefit of providing us a lot of helper functions to work with validation

## Validating Request
- We can define `Request class` to validate easily incoming HTTP requests.
- We inject `Request class` in controller methods to get Laravel to perform validation requests
- We can create `custom validation` rule either by `closure` or a `dedicated Rule class`

## TDD(Test driven development):
- `Test driven development(TDD)` is the idea of writing test first and write the code later
- In standard TDD, we would write the bare minimum code to pass our test and refactor our code as we progress to the advanced tests.

## Testing(Feature tests):

- Providing the '-filter' flag to PHP unit allows us to run a specific test
- Event::fake() stops events from dispatching in our app and allows us to capture and assert event dispatching
- The json() method allows us to easily perform HTTP requests to our API endpoints

## PHP Unit test vs Feature test vs E2E test

- Unit testing is the notion of the testing the smallest units/building block in our app i.e. functions. If the building blocks are working, then the app should work(not necessarily true always)

- Feature testing focuses on the feature and outcome rather than the individual functions, It is more reliable that unit testing but slower

- End to End testing mocks the end users behaviour and has the highest reliability. However, E2E is very hard to implement and very slow

## Email 
- command to generate an email:
    `php artisan make:mail WelcomeMail`
- Additional configuration in mail template:
    `php artisan vendor:publish`
- we need a fake SMTP server
    - mailtrap.io

## Event & event listener & subscriber
- `Event listeners` are classes /functions that get executed when an event is dispatched
- We define our `Event` - `Event Listener` mapping in the `Event Service Provider`
- `Event Subscriber` is a class that let us to group our **event listener mapping** in one place.
- We register `Subscribers` in the $subscribe property from the Event Service provider.
## Exception

1. Creating custom exception classes in our app can *ensure consistent* API response for error handling
2. The `report()` method is responsible for reporting or logging the exception.
3. The `render()` method is responsible to send the error back to the HTTP client.
4. The `abort()` helper function is a quick way to send back an error response.
5. The `report()` helper function call the report method in the specified exception class.
## Repository pattern

1. Repository is a class that takes care of model operations
2. Repository manages model operations in one place and improves the maintainability of our app
3. The common methods present in all repository can be implemented by an abstract base class, this way we can enforce the methods must be implemented

## Pagination 

1. *Pagination* is the notion of displaying our query results by page, otherwise we would have to send everything to the client
2. We call the `paginate()` method on our query to create  a paginator. We can then pass the paginator to our resource collection for a paginated JSON response.
## Laravel Resource Class | API Resource

1. Resource class help us to manage our **API JSON** response in one place
2. It makes our API response to be more consistent and maintainable
3. We can use the command below to generate resource boilerplate
`php artisan make:resource ReourceName`

## Database transaction

1. *Database transaction* groups multiple database together and only applies the operations **when all of them passed**. It will **rollback any changes** if one of the operations failed.

2. We use the `transaction()` method in the `DB facade` to trigger a transaction
## Essential eloquent methods and properties

1. Larvel's ORM - Eloquent provides an easy API for us to work with database
2. We use the `query()` method to start a database query , `get()` to retrieve records, `find()` to find by id, `create()` to insert record, `update()` to update and `delete()` to delete
3. Laravel protects the model fields from *mass assignment*  by default. To enable mass assignment, we will need to define the `$fillable` or `$guarded` property in the model.
4. `$hidden` will hide model fields when we convert the model into an array. and `$append` will add extra fields to the array from the accessor method. 

## Recursively load PHP files in a directory

1. **Iterator** is an object that allows us to iterate through a series of items
2. The **directory iterator** can help us to automatically load our routes in a folder

## Laravel api routes best practices

1. Route group can help us to effectively organise our API routes
2. We can either use the *array syntax* or the *method syntax* to define a route group.
3. We can add `URL prefix`, `route name prefix (name, as)` , `namespace` and `middleware` to a route group
4. The `where()` method is useful to add matching constraint to URL params.

## Controllers:

1. Controller is a function that runs when a HTTP request hits a route
2. We can delegate our route controllers into a dedicated Laravel Controller class.
3. There are 5 main methods in a controller class:
    - `Index`- displays a list of resources
    - `Store` - creates a new resources
    - `Show` - display a specific resources
    - `Update`- updates a specific resources
    - `Destroy` - deletes a specific resources
4. The *resource/apiResources* route helper method enables us to easily define API routes



## RESTful API Route Design and Laravel Routes

Architectural constraints: Rest defines *6 architectural constraints* which make any web service a true RESTFUL API.

1. Uniform interface
2. Client-server
3. Stateless
4. Cache able
5. Layered system
6. Code on demand(optional)

**Takeaways:**
1. Api routes typically refers to routes that return Json, while web routes are routes that return HTML pages
2. We define API routes in the `api.php` file, and web routes in `web.php`
3. Laravel uses the `substitute bindings middleware` to automagically load model instance to the controller 


## Seeding relationships

1. Laravel offers us factory helper functions like 
`has()` and `for()` to quickly generate relations for our models
2. We can use the `sync` method to generate many to many relation records **(pivot table)**

## Model:

Key topics in model:
1. Accessor(getter)
2. Mutator (setter)
3. Relationship
4. Casting

**Takeaways**
1. We use `hasMany()` and `belongsTo()` methods to define `one to many relationship`
2. `BelongsToMany()` is used to define `many to many` relationship. We use `attach()`, `detach()`, `toggle()`, and `sync()` to associate relations.
3. `Accessors` and `mutators` transform values when we retrieve/set model attributes.
4. `Casting` is used to cast a datatype to another while retrieving data i.e. cast to array automatically save as json and retrieve as an array. 

## SEEDS and Fatories:

1. `Seeding` is referred to populating the database with dummy data
2. Factory classes are used to generate fake models
3. We can use the `db:seed` Artisan command to trigger the seeders
## Database migration:

1. Migration is a concept of version control for database
2. Laravel will run migration files in *chronological order* ,i.e. by following the timestamp in the migration file name
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

2. The `register()` method is where define our class binding

3. The `boot()` method is called after all services are registered.

4. We need to put our Service Provider in the **provider** array in the app config file to activate it. Otherwise Laravel will automatically resolve the Service on its own using the **Automatic Resolution** feature

##  Middleware and Http Kernel:
1. Middleware are functions that run before the request hits the router
2. The `handle()` method contains the main logic of the middleware, while the `terminate()` method contains the **clean up** logic just before the app is shut down.

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

4. **Singleton service** can only have 1 instance

5. **Kernel** is the core of an app that does all the heavy work for us

