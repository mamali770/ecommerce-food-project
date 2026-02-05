<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create() {
        return view('categories.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|numeric'
        ]);

        Category::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return redirect()->route('category.index')->with('success', 'دسته بندی با موفقیت ایجاد شد');
    }

    public function edit(Category $categories) {
        return view('categories.edit', compact('categories'));
    }

    public function update(Request $request, Category $categories) {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|string'
        ]);

        $categories->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return redirect()->route('category.index')->with('success', 'دسته بندی با موفقیت ویرایش شد');
    }

    public function destroy(Category $categories) {
        $categories->delete();
        return redirect()->route('category.index')->with('warning', 'دسته بندی با موفقیت حذف شد');
    }
}
