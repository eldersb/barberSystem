<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return Cache::remember('categories', 3600, function () {  
            return CategoryResource::collection($this->category->all());
        });
    
    }

    public function searchByName(string $name)
    {
        return Category::where('name', 'LIKE', "%{$name}%")->get();
    }

    public function create(array $data)
    {
        $category = $this->category->create($data);

        Cache::forget('barbers');

        Cache::put('categories', CategoryResource::collection($this->category->all()), 3600);

        return $category;

    }

    public function getById(string $id)
    {
        return $this->category->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $category = $this->getById($id);
       
        $category->update($data);

        Cache::forget('categories');

        Cache::put('categories', CategoryResource::collection($this->category->all()), 3600);

        return $category;
    }

    public function delete(string $id): void
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
