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

* Create a call which will return all the users which are `active` (users table) and have an Austrian citizenship.
* Create a call which will allow you to edit user details just if the user details are there already.
* Create a call which will allow you to delete a user just if no user details exist yet.
* Write a feature test for 3. with valid and invalid data

## Steps
* Install Laravel 8 
* Setup .env file 
* For importing the database file (\database\database.sql) thire was two ways :
1.  Load the file directly in `DatabaseSeeder.php` and run `php artisan db:seed` but in this case the migration and the data will be loaded in same step which may cause distraction on testing phase by having database already filled with data.
```
    // load database.sql
    $path = str_replace("seeders", "database.sql", __DIR__);
    DB::unprepared($path);
```
2. Create seperate migrations, seeders and factories foreach table in this case migration and data can be under controll in testing phase by running only the migration to create an empty clean database schema for each test (also any specific seeder needer can be run like seeding the countries with each test).

    I used the second way which required more work but at the end it provided an clean testing env.
* Set up the models and relations.
* Set up the API routes.
* Implement `AppendJsonHeaders` middleware which attach the required json headers for any route throw the api routes (This tells the app to render exeptions in json).
* Implement `Controllers`.
* Implement `FormRequests` to handle request validation.
* Implement `Services` to handle the business logic.
* Implement `Validators` as an extra layer of validation to handle logical validation like prevent deleting user if has details (action like delete user should call `$userValidator->canBeDeleted()` which call the required validations using this approch a new validation roles should be easier by adding the new role call to `canBeDeleted()` function);
* Implement `Repostitories` to handle database layer.
* Implement `API Resources` to control the response.
* Implement `FeatureTests` to check all possiable API calls (with valid and invalid data).
* Implement `UnitTests` to check each unit (function) isolated with seperated test.
## App Structure 
As mentioned before there are multiple layers which helps to isolate layers from each others, make code more cleaner which helps to write more accurate `UnitTests`

Example: (Update User API)
1. `UserDetailsController` receives the request and model binging to get the user and dependency injection to create an object from the `UpdateUser` FormRequest.
2. FormRequest handles the simple validation and throw exeptions in validation fails.
3. Contoller passess the data to the `UserDetailsService` which handles the logic.
4. Call `UserDetailsValidator` to complete validation process.
5. Call `UserDetailsRepository` to update data.
6. Return the response to controller with passess it to `UserResource`.

## How to run
1. Clone the project.
2. Set up .env
3. Run `php artisan migrate --seed` which will seed the database exactly like `database.sql`
4. Run `php artisan test`
5. Run `php artisan serv`
## API's
1. GET `/api/v1/users` : index all active users in the database , accepts `country_id` as query param to filter by country (ex. ?country_id=1 filter active Austrian citizenship).
2. DELETE `/api/v1/users/{user}` : deletes the given user if user doesn't have details.
2. PATCH `/api/v1/users/{user}/details` : update one or more user details attributes only if user details exists.














