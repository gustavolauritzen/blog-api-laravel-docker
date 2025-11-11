<?php

  namespace Database\Seeders;

  use App\Models\Category;
  use App\Models\Post;
  use App\Models\Tag;
  use App\Models\User;
  use Illuminate\Database\Seeder;

  class PostSeeder extends Seeder
  {
      /**
       * Run the database seeds.
       */
      public function run(): void
      {
          // Create a test user if it doesn't exist
          $user = User::firstOrCreate(
              ['email' => 'john@example.com'],
              [
                  'name' => 'John Doe',
                  'password' => bcrypt('password'),
              ]
          );

          // Get some categories and tags
          $techCategory = Category::where('slug', 'technology')->first();
          $programmingCategory = Category::where('slug', 'programming')->first();
          $designCategory = Category::where('slug', 'design')->first();

          $laravelTag = Tag::where('slug', 'laravel')->first();
          $phpTag = Tag::where('slug', 'php')->first();
          $dockerTag = Tag::where('slug', 'docker')->first();
          $apiTag = Tag::where('slug', 'api')->first();
          $tutorialTag = Tag::where('slug', 'tutorial')->first();

          // Post 1 - Published
          $post1 = Post::create([
              'user_id' => $user->id,
              'category_id' => $programmingCategory->id,
              'title' => 'Getting Started with Laravel 11',
              'slug' => 'getting-started-with-laravel-11',
              'excerpt' => 'Learn the basics of Laravel 11 and start building amazing web applications.',
              'content' => 'Laravel is a powerful PHP framework that makes web development a breeze. In this tutorial, we will explore the key features of Laravel 11 and build a simple application from 
  scratch. Laravel provides an elegant syntax and powerful tools like Eloquent ORM, Blade templating, and built-in authentication.',
              'image' => 'laravel-tutorial.jpg',
              'published' => true,
              'published_at' => now()->subDays(7),
          ]);
          $post1->tags()->attach([$laravelTag->id, $phpTag->id, $tutorialTag->id]);

          // Post 2 - Published
          $post2 = Post::create([
              'user_id' => $user->id,
              'category_id' => $techCategory->id,
              'title' => 'Docker for Developers: A Complete Guide',
              'slug' => 'docker-for-developers-complete-guide',
              'excerpt' => 'Master Docker and containerization for modern application development.',
              'content' => 'Docker has revolutionized the way we develop and deploy applications. By using containers, developers can ensure consistency across different environments. This guide covers 
  everything from basic Docker commands to orchestrating multi-container applications with Docker Compose.',
              'image' => 'docker-guide.jpg',
              'published' => true,
              'published_at' => now()->subDays(5),
          ]);
          $post2->tags()->attach([$dockerTag->id, $tutorialTag->id]);

          // Post 3 - Published
          $post3 = Post::create([
              'user_id' => $user->id,
              'category_id' => $programmingCategory->id,
              'title' => 'Building RESTful APIs with Laravel',
              'slug' => 'building-restful-apis-with-laravel',
              'excerpt' => 'Create robust and scalable REST APIs using Laravel and best practices.',
              'content' => 'REST APIs are the backbone of modern web applications. Laravel makes it incredibly easy to build clean and maintainable APIs. In this article, we explore routing, controllers, 
  resources, authentication with Sanctum, and API versioning strategies.',
              'image' => 'rest-api.jpg',
              'published' => true,
              'published_at' => now()->subDays(3),
          ]);
          $post3->tags()->attach([$laravelTag->id, $apiTag->id, $phpTag->id]);

          // Post 4 - Draft (not published)
          $post4 = Post::create([
              'user_id' => $user->id,
              'category_id' => $designCategory->id,
              'title' => 'Modern UI Design Principles',
              'slug' => 'modern-ui-design-principles',
              'excerpt' => 'Explore the fundamental principles of modern user interface design.',
              'content' => 'Great UI design is about more than just aesthetics. It\'s about creating intuitive, accessible, and delightful experiences for users. This article covers key principles like 
  hierarchy, contrast, consistency, and feedback. We\'ll also look at popular design systems and tools.',
              'image' => null,
              'published' => false,
              'published_at' => null,
          ]);
          $post4->tags()->attach([$tutorialTag->id]);
      }
  }