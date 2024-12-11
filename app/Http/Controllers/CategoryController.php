<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        dd('Requisição chegou!'); 
        
        $category = Category::create($request->validated());

        return response()->json(new CategoryResource($category), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json($category);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Categoria não encontrada.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try{
            $category= Category::findOrFail($id);

            $category->update($request->validated());

            return response()->json(new CategoryResource($category), 200);

        }catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => "Categoria não encontrada!",
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            
            return response()->json('Categoria deletada ccom sucesso!', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Cateogoria não encontrada.'
            ], 404);
        }
    }
}
