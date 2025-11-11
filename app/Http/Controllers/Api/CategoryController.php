<?php

  namespace App\Http\Controllers\Api;

  use App\Http\Controllers\Controller;
  use App\Models\Category;
  use Illuminate\Http\Request;

  class CategoryController extends Controller
  {
      /**
       * Display a listing of categories.
       */
      public function index()
      {
          $categories = Category::withCount('posts')->get();

          return response()->json($categories);
      }

      /**
       * Store a newly created category.
       */
      public function store(Request $request)
      {
          $request->validate([
              'name' => 'required|string|max:255',
              'slug' => 'required|string|max:255|unique:categories',
              'description' => 'nullable|string',
          ]);

          $category = Category::create($request->all());

          return response()->json($category, 201);
      }

      /**
       * Display the specified category.
       */
      public function show(Category $category)
      {
          $category->loadCount('posts');

          return response()->json($category);
      }

      /**
       * Update the specified category.
       */
      public function update(Request $request, Category $category)
      {
          $request->validate([
              'name' => 'sometimes|required|string|max:255',
              'slug' => 'sometimes|required|string|max:255|unique:categories,slug,' . $category->id,
              'description' => 'nullable|string',
          ]);

          $category->update($request->all());

          return response()->json($category);
      }

      /**
       * Remove the specified category.
       */
      public function destroy(Category $category)
      {
          $category->delete();

          return response()->json([
              'message' => 'Category deleted successfully'
          ]);
      }
  }