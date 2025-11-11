<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class Post extends Model
  {
      use HasFactory;

      /**
       * The attributes that are mass assignable.
       *
       * @var array<int, string>
       */
      protected $fillable = [
          'user_id',
          'category_id',
          'title',
          'slug',
          'excerpt',
          'content',
          'image',
          'published',
          'published_at',
      ];

      /**
       * The attributes that should be cast.
       *
       * @var array<string, string>
       */
      protected $casts = [
          'published' => 'boolean',
          'published_at' => 'datetime',
      ];

      /**
       * Get the user that owns the post.
       */
      public function user()
      {
          return $this->belongsTo(User::class);
      }

      /**
       * Get the category that owns the post.
       */
      public function category()
      {
          return $this->belongsTo(Category::class);
      }

      /**
       * The tags that belong to the post.
       */
      public function tags()
      {
          return $this->belongsToMany(Tag::class);
      }
  }