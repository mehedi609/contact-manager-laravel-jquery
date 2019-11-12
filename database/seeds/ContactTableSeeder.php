<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ContactTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('contacts')->truncate();

    $contacts = [];
    $faker = Faker::create();

    for ($i = 0; $i < 20; $i++) {
      $contacts[] = [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => "{$faker->streetname} {$faker->postcode} {$faker->city}",
        'company' => $faker->company,
        'group_id' => rand(1, 3),
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ];
    }

    DB::table('contacts')->insert($contacts);
  }
}
