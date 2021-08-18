## PHP Technical task
Create a new Laravel project using composer
Attached you will find a DB dump. Create a DB connection in laravel using the .env file. 
Seed the DB based on the dump

In the resulted DB you will have these 3 tables: `users`, `countries` and `user_details`.
```
* users: id, email, active
* countries: id, name, iso2, iso3 
* user_details: id, user_id, citizenship_country_id, first_name, last_name, phone_number
```

* Create a call that will return all the users who are `active` (users table) and have Austrian citizenship.
* Create a call that will allow you to edit user details just if the user details are there already.
* Create a call which will allow you to delete a user just if no user details exist yet.
* Write a feature test for 3. with valid and invalid data

## Steps
* Install Laravel 8 
* Setup .env file 
* For importing the database file (\database\database.sql) there were two ways :
1.  Load the file directly in `DatabaseSeeder.php` and run `php artisan db:seed` but in this case, the migration and the data will be loaded in the same step which may cause distraction on the testing phase by having the database already filled with data.
```
    // load database.sql
    $path = str_replace("seeders", "database.sql", __DIR__);
    DB::unprepared($path);
```
2. Create separate migrations, seeders and factories for each table in this case migration and data can be under control in the testing phase by running only the migration to create an empty clean database schema for each test (also any specific seeder needer can be run like seeding the countries with each test).

    I used the second way which required more work but at the end it provided an clean testing env.
* Set up the models and relations.
* Set up the API routes.
* Implement `AppendJsonHeaders` middleware which attaches the required JSON headers for any route throw the API routes (This tells the app to render exceptions in JSON).
* Implement `Controllers`.
* Implement `FormRequests` to handle request validation.
* Implement `Services` to handle the business logic.
* Implement `Validators` as an extra layer of validation to handle logical validation like preventing deleting user if has details (action like delete user should call `$userValidator->canBeDeleted()` which call the required validations using this approach a new validation role should be easier by adding the new role call to `canBeDeleted()` function);
* Implement `Repostitories` to handle the database layer.
* Implement `API Resources` to control the response.
* Implement `FeatureTests` to check all possible API calls (with valid and invalid data).
* Implement `UnitTests` to check each unit (function) isolated with a separated test env.

## App Structure 
As mentioned before there are multiple layers that help to isolate layers from each other, make code more cleaner which helps to write more accurate `UnitTests`

Example: (Update User API)
1. `UserDetailsController` receives the request and model binging to get the user and dependency injection to create an object from the `UpdateUser` FormRequest.
2. FormRequest handles the simple validation and throw exceptions if validation fails.
3. Controller passes the data to the `UserDetailsService` which handles the logic.
4. Call `UserDetailsValidator` to complete the validation process.
5. Call `UserDetailsRepository` to update data.
6. Return the response to the controller with passes it to `UserResource`.

## How to run

### Docker
For running with docker use [Laravel Sail](https://laravel.com/docs/8.x/sail) package which is already included in `composer.json`, simply it's a `docker-compose` came with PHP, MySQL, and Redis and it'ss ready to start with one single command .
1. Clone the project.
2. Run `composer install`
3. Run `sail up -d`

### Local

1. Clone the project.
2. Run `composer install`
3. Set up .env
4. Run `php artisan migrate --seed` which will seed the database exactly like `database.sql`
5. Run `php artisan test`
6. Run `php artisan serv`

## API's
1. GET `/api/v1/users` : index all active users in the database , accepts `country_id` as query param to filter by country (ex. ?country_id=1 filter active Austrian citizenship).
2. DELETE `/api/v1/users/{user}` : deletes the given user if the user doesn't have details.
2. PATCH `/api/v1/users/{user}/details` : update one or more user details attributes only if user details exists.
