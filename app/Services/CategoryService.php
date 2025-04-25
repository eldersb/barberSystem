<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return $this->category->all();
    }

    public function searchByName(string $name)
    {
        return Category::where('name', 'LIKE', "%{$name}%")->get();
    }

    public function create(array $data)
    {
        return $this->category->create($data);
    }

    public function getById(string $id)
    {
        return $this->category->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $category = $this->getById($id);
       
        $category->update($data);

        return $category;
    }

    public function delete(string $id): void
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
