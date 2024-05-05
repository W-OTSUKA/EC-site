<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class categoryController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('Admin/auth/categories', compact('categories'));
    
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.create')->with('success', 'カテゴリーが登録されました');
    }

    public function delete($id)
{
    $category = Category::find($id);

    if (!$category) {
        return redirect()->route('admin.categories.create')->with('error', 'カテゴリーが見つかりませんでした');
    }

    // カテゴリーに関連付けられているアイテムが存在するかを確認
    if ($category->item()->exists()) {
        return redirect()->route('admin.categories.create')->with('error', 'このカテゴリーには関連付けられたアイテムが存在するため、削除できません');
    }

    // カテゴリーの削除を実行
    $category->delete();

    return redirect()->route('admin.categories.create')->with('success', 'カテゴリーが削除されました');
}
}
