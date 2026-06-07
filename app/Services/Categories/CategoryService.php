<?php

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
  public function index()
{
    $categories = Category::orderBy('id', 'desc')->paginate(10);
    return view('admin.categories.index', compact('categories'));
}


    public function store(array $data): Category
{
    $data['is_active'] = isset($data['is_active']) ? 1 : 0;
    return Category::create($data);
}


    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
