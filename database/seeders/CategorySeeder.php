<?php

  namespace Database\Seeders;

  use App\Models\Category;
  use Illuminate\Database\Seeder;

  class CategorySeeder extends Seeder
  {
      /**
       * Run the database seeds.
       */
      public function run(): void
      {
          $categories = [
              [
                  'name' => 'Technology',
                  'slug' => 'technology',
                  'description' => 'Articles about technology trends and innovations',
              ],
              [
                  'name' => 'Programming',
                  'slug' => 'programming',
                  'description' => 'Programming tutorials and best practices',
              ],
              [
                  'name' => 'Design',
                  'slug' => 'design',
                  'description' => 'UI/UX design tips and inspiration',
              ],
              [
                  'name' => 'Business',
                  'slug' => 'business',
                  'description' => 'Business strategies and entrepreneurship',
              ],
              [
                  'name' => 'Lifestyle',
                  'slug' => 'lifestyle',
                  'description' => 'Lifestyle tips and personal development',
              ],
          ];

          foreach ($categories as $category) {
              Category::create($category);
          }
      }
  }