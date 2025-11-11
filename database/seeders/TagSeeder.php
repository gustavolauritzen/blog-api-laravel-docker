<?php

  namespace Database\Seeders;

  use App\Models\Tag;
  use Illuminate\Database\Seeder;

  class TagSeeder extends Seeder
  {
      /**
       * Run the database seeds.
       */
      public function run(): void
      {
          $tags = [
              ['name' => 'Laravel', 'slug' => 'laravel'],
              ['name' => 'PHP', 'slug' => 'php'],
              ['name' => 'Docker', 'slug' => 'docker'],
              ['name' => 'API', 'slug' => 'api'],
              ['name' => 'REST', 'slug' => 'rest'],
              ['name' => 'Tutorial', 'slug' => 'tutorial'],
              ['name' => 'Backend', 'slug' => 'backend'],
              ['name' => 'Database', 'slug' => 'database'],
              ['name' => 'MySQL', 'slug' => 'mysql'],
              ['name' => 'Development', 'slug' => 'development'],
          ];

          foreach ($tags as $tag) {
              Tag::create($tag);
          }
      }
  }