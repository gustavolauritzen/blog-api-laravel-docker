<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
  {
      // Run seeders in order (categories and tags first, then posts)
      $this->call([
          CategorySeeder::class,
          TagSeeder::class,
          PostSeeder::class,
      ]);
  }
}
