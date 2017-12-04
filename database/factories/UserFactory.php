<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Area::class, function (Faker $faker) {

    return [
        'name' => $faker->city,
        'description' => $faker->sentence
    ];
});

$factory->define(App\Models\Market::class, function (Faker $faker) {
  $name = $faker->city;
  return [
    'name' => $name,
    'address' => $faker->address,
    'lat' => $faker->latitude,
    'lng' => $faker->longitude,
  ];
});

$factory->define(App\Models\Product::class, function (Faker $faker) {

  return [
    'code' => $faker->unique()->ean8,
    'name' => $faker->streetName,
    'measurement' => $faker->word,
    'price' => $faker->numberBetween(100000, 200000)
  ];
});

$factory->define(App\Models\Stokist::class, function (Faker $faker) {
  return [
    'code' => $faker->unique()->ean8,
    'name' => $faker->company,
    'owner' => $faker->name,
    'pic' => $faker->name,
    'phone1' => $faker->e164PhoneNumber,
    'phone2' => $faker->e164PhoneNumber,
    'email' => $faker->unique()->email,
    'address' => $faker->address,
    'lat' => $faker->latitude,
    'lng' => $faker->longitude,
  ];
});
