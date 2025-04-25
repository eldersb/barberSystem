<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll();
        return response()->json($categories);
    }

    public function search(Request $request)
    {
        try {
            $name = $request->query('name');
    
            if (!$name) {
                return response()->json([
                    'message' => 'Parâmetro "name" é obrigatório.'
                ], 400);
            }
    
            $categories = $this->categoryService->searchByName($name);
    
            if ($categories->isEmpty()) {
                return response()->json([
                    'message' => 'Nenhuma categoria encontrada.'
                ], 404);
            }
    
            return response()->json($categories);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro interno ao buscar categoria.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());
        return response()->json(new CategoryResource($category), 201);
    }

    public function show(string $id)
    {
        try {
            $category = $this->categoryService->getById($id);
            return response()->json($category);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Categoria não encontrada.'], 404);
        }
    }

    public function update(CategoryRequest $request, string $id)
    {
        try {
            $category = $this->categoryService->update($id, $request->validated());
            return response()->json(new CategoryResource($category));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Categoria não encontrada!'], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->categoryService->delete($id);
            return response()->json('Categoria deletada com sucesso', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Categoria não encontrada.'], 404);
        }
    }
}
