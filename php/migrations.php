<?php
require './init.php';
use Illuminate\Database\Capsule\Manager as DB;

    DB::schema()->create('clients', function ($table) {
        $table->increments('id');
        $table->string('email')->unique()->nullable(false);
        $table->text('name')->nullable(true);
        $table->text('phone')->nullable(true);
    });
    echo "Таблица clients создана\n";
    DB::schema()->create('orders', function ($table) {
        $table->increments('id');
        $table->integer('client_id')->unsigned()->nullable(false);
        $table->foreign('client_id')->references('id')->on('clients');
        $table->text('address')->nullable(false);
        $table->text('comment')->nullable(true);
    });
    echo "Таблица orders создана\n";
    $faker = Faker\Factory::create(); //Здесь у нас Generator
    $faker->addProvider(new Faker\Provider\ru_RU\Person($faker));
    $faker->addProvider(new Faker\Provider\ru_RU\PhoneNumber($faker));
    $faker->addProvider(new Faker\Provider\ru_RU\Address($faker));
    $faker->addProvider(new Faker\Provider\ru_RU\Text($faker));

    for ($i = 0; $i < 20; $i++) {
        DB::table('clients')->insert([
            'email' => $faker->email,
            'name' => $faker->firstName,
            'phone' => $faker->phoneNumber
        ]);
    }
    echo "Таблица clients заполнена\n";
    for ($i = 0; $i < 20; $i++) {
        DB::table('orders')->insert([
            'client_id' => round(rand(1, 20)),
            'address' => $faker->address,
            'comment' => $faker->text(140),
        ]);
    }
    echo "Таблица orders заполнена\n";