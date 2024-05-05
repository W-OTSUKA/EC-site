<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserItemController extends Controller
{
    public function create()
    {
        return view('dashboard');
    }

    public function userCreate(Request $request)
{
    // 検索フォームからのクエリを取得
    $search = $request->input('search');
    // カテゴリーIDを取得
    $category_id = $request->input('category_id');

    // カテゴリーを取得
    $categories = Category::all();

    // クエリビルダーを作成
    $query = Item::query();

    // クエリにキーワードがあれば、名前で検索
    if ($search) {
        $query->where('name', 'like', "%$search%");
    }

    // カテゴリーIDが指定されていれば、そのカテゴリーのアイテムを検索
    if ($category_id) {
        $query->where('category_id', $category_id);
    }

    // ページネーションを適用して結果を取得
    $values = $query->paginate(12);
    
    return view('dashboard', compact('values', 'categories'));
}

    public function itemDetails($itemId)
    {
        $item = Item::find($itemId);
        
        return view('auth/item-details',compact('item') );
    }
}
