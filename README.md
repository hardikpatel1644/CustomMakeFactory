# Laravel Custom Make Factory command
  Laravel custom make factory command that will generate the factory class
------------------------------------------------------------------------------------------
Steps to install laravel 
- Clone this repository using this command : git clone https://github.com/hardikpatel1644/CustomMakeFactory.git
- Change the .env file.
    - change the database details 
        DB_DATABASE=#Your Database Name# eg.laravel_custom_make_factory
        DB_USERNAME=#Your Database Username#
        DB_PASSWORD=#Your Database Password#
Note :  Please create database in mysql as per config database name.
------------------------------------------------------------------------------------------
Create new Model with schema and factory class
- php artisan make:model Patient -mf

This command will generate the following files in respective directories.
- Patient.php - \app\Patient.php
- PatientFactory.php - \database\factories\PatientFactory.php
- Schema -  \database\migrations\2021_01_29_025819_create_patients_table.php
------------------------------------------------------------------------------------------
Add follwing fields in 2021_01_29_025819_create_patients_table.php
first_name , last_name , email , age , date_of_birth , status
- your up() method should look like this.
```
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->integer('age');
            $table->date('date_of_birth');
            $table->boolean('status');
            $table->timestamps();
        });
    }
 ```   
- Run migration - php artisan migrate - This will generate schema in your database.
------------------------------------------------------------------------------------------
Add fillable fields in App\Patient.php 

    protected $fillable = [
        'first_name', 'last_name', 'email', 'age', 'date_of_birth', 'status'
    ];
------------------------------------------------------------------------------------------
Create new laravel command to extend default factory class
- Run this command - php artisan make:command CustomMakeFactory - that will generate new file in \app\Console\Commands.
- That class will extend the default factory class.
- Added and change some methods to override default methods from the parent class.
    - getOptions()
    - buildClass()
    - Change in constructor 
    ```
        public function __construct(Filesystem $files)
        {
            parent::__construct($files);
        }
    ```    
    - Delete signature and description variables.
------------------------------------------------------------------------------------------
Create service provider to use Custom Factory class.
- Run this command -  php artisan make:provider CustomMakeFactoryServiceProvider
- It will generate the provider class in - \app\Providers
- Change register method to call CustomMakeFactory class
    ```
    public function register()
    {
        parent::register();
        $this->app->singleton('command.factory.make', function ($app) {
            return new CustomMakeFactory($app['files']);
        });
    }
    ```
- to use service provider - Please add class definition in "providers" at the very end.
           App\Providers\CustomMakeFactoryServiceProvider::class,
------------------------------------------------------------------------------------------
To generate factory Model class using CustomMakeFactory class, Use follwing command.
- php artisan make:factory --model=Patient --faker PatientHPFactory
    - --model=Patient : Name of model
    - --faker PatientHPFactory : The name of factory class which will be generated by CustomMakeFactory class.
-----------------------------------------------------------------------------------------

Note : If you get following error,  
        Class 'Doctrine\DBAL\Driver\PDOMySql\Driver' not found
        
        Please run following command to add dependecy and download the library for doctrine/dbal
      - composer require doctrine/dbal - It will dowload required libraries.

-----------------------------------------------------------------------------------------

Result :

There are default factory class and custom generated class in this directory "\database\factories"
- PatientFactory.php - Default Factory class 
- PatientHPFactory.php - Generated by custom artisan facory command. (CustomMakeFactory class)

Generated class will look like this.
```
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'first_name' => $faker->word,
		'last_name' => $faker->word,
		'email' => $faker->word,
		'age' => $faker->number,
		'date_of_birth' => $faker->date,
		'status' => $faker->boolean,
		
    ];
});
```

-----------------------------------------------------------------------------------------


References 

    - https://kaloraat.com/articles/generate-fake-data-using-faker-and-factory-in-laravel
    - https://medium.com/dev-genius/laravel-8-x-database-seeders-fakers-and-factories-7cb759918124
    - https://blog.quickadminpanel.com/list-of-21-artisan-make-commands-with-parameters
    - https://laravel.com/docs/8.x/providers








