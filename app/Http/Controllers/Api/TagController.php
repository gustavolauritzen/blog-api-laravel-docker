<?php

  namespace App\Http\Controllers\Api;

  use App\Http\Controllers\Controller;
  use App\Models\Tag;
  use Illuminate\Http\Request;

  class TagController extends Controller
  {
      /**
       * Display a listing of tags.
       */
      public function index()
      {
          $tags = Tag::withCount('posts')->get();

          return response()->json($tags);
      }

      /**
       * Store a newly created tag.
       */
      public function store(Request $request)
      {
          $request->validate([
              'name' => 'required|string|max:255',
              'slug' => 'required|string|max:255|unique:tags',
          ]);

          $tag = Tag::create($request->all());

          return response()->json($tag, 201);
      }

      /**
       * Display the specified tag.
       */
      public function show(Tag $tag)
      {
          $tag->loadCount('posts');

          return response()->json($tag);
      }

      /**
       * Update the specified tag.
       */
      public function update(Request $request, Tag $tag)
      {
          $request->validate([
              'name' => 'sometimes|required|string|max:255',
              'slug' => 'sometimes|required|string|max:255|unique:tags,slug,' . $tag->id,
          ]);

          $tag->update($request->all());

          return response()->json($tag);
      }

      /**
       * Remove the specified tag.
       */
      public function destroy(Tag $tag)
      {
          $tag->delete();

          return response()->json([
              'message' => 'Tag deleted successfully'
          ]);
      }
  }