<?php

  namespace App\Http\Controllers\Api;

  use App\Http\Controllers\Controller;
  use App\Models\Post;
  use Illuminate\Http\Request;

  class PostController extends Controller
  {
      /**
       * Display a listing of posts.
       */
      public function index()
      {
          $posts = Post::with(['user', 'category', 'tags'])
              ->latest()
              ->get();

          return response()->json($posts);
      }

      /**
       * Store a newly created post.
       */
      public function store(Request $request)
      {
          $request->validate([
              'title' => 'required|string|max:255',
              'slug' => 'required|string|max:255|unique:posts',
              'excerpt' => 'nullable|string',
              'content' => 'required|string',
              'image' => 'nullable|string',
              'category_id' => 'required|exists:categories,id',
              'published' => 'boolean',
              'published_at' => 'nullable|date',
              'tags' => 'nullable|array',
              'tags.*' => 'exists:tags,id',
          ]);

          // Create post with authenticated user
          $post = $request->user()->posts()->create($request->except('tags'));

          // Attach tags if provided
          if ($request->has('tags')) {
              $post->tags()->attach($request->tags);
          }

          // Load relationships for response
          $post->load(['user', 'category', 'tags']);

          return response()->json($post, 201);
      }

      /**
       * Display the specified post.
       */
      public function show(Post $post)
      {
          $post->load(['user', 'category', 'tags']);

          return response()->json($post);
      }

      /**
       * Update the specified post.
       */
      public function update(Request $request, Post $post)
      {
          // Check authorization
          if ($request->user()->id !== $post->user_id) {
              return response()->json([
                  'message' => 'Unauthorized'
              ], 403);
          }

          $request->validate([
              'title' => 'sometimes|required|string|max:255',
              'slug' => 'sometimes|required|string|max:255|unique:posts,slug,' . $post->id,
              'excerpt' => 'nullable|string',
              'content' => 'sometimes|required|string',
              'image' => 'nullable|string',
              'category_id' => 'sometimes|required|exists:categories,id',
              'published' => 'boolean',
              'published_at' => 'nullable|date',
              'tags' => 'nullable|array',
              'tags.*' => 'exists:tags,id',
          ]);

          // Update post
          $post->update($request->except('tags'));

          // Sync tags if provided
          if ($request->has('tags')) {
              $post->tags()->sync($request->tags);
          }

          // Load relationships for response
          $post->load(['user', 'category', 'tags']);

          return response()->json($post);
      }

      /**
       * Remove the specified post.
       */
      public function destroy(Request $request, Post $post)
      {
          // Check authorization
          if ($request->user()->id !== $post->user_id) {
              return response()->json([
                  'message' => 'Unauthorized'
              ], 403);
          }

          $post->delete();

          return response()->json([
              'message' => 'Post deleted successfully'
          ]);
      }
  }