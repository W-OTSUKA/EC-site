<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::All();
        return view('Admin/auth/item-register',compact('categories'));
    }

    public function itemRegister(Request $request)
    {
        // バリデーションを先に行う
        $request->validate([
            'name' => 'required',
            'img_path' => 'required',
            'memo' => 'required|max:200', 
            'price' => 'required|numeric' // 数値であることを確認
        ],
        [
            'name.required' => '商品名は必須項目です。',
            'img_path.required' => '画像の選択は必須です。',
            'memo.required' => '商品説明は必須項目です。',
            'memo.max' => '商品説明は200文字未満で入力してください。',
            'price.required' => '価格は必須項目です。',
            'price.numeric' => '価格は数値で入力してください。'
        ]);
    
        // バリデーションが成功した場合のみ InsertItem メソッドを呼び出す
        (new Item())->InsertItem($request);

        
    
        // リダイレクト
        return redirect()->route('admin.itemRegister.create');
    }


    public function adminCreate(Request $request)
    {

        // 検索フォームからのクエリを取得
    $search = $request->input('search');
    $category_id = $request->input('category_id'); // カテゴリーIDを取得
    // クエリビルダを作成
    $query = Item::where('admin_id', Auth::id());
    
    // 検索クエリがある場合は、それを使ってアイテムを検索
    if ($search) {
        $query->where('name', 'like', "%$search%");
    }
    
    // カテゴリーIDが指定されている場合は、そのカテゴリーのアイテムを検索
    if ($category_id) {
        $query->where('category_id', $category_id);
    }
    
    // 結果をページネーションして取得
    $values = $query->paginate(10);
    
    // カテゴリーを取得
    $categories = Category::all();

    return view('admin/dashboard', compact('values','categories'));
    }
    
    
     // 編集フォーム表示
    public function itemEdit($id)
    {
        // 商品を取得して編集フォームに渡す
        $item = Item::find($id);
        $categories = Category::All();
        
        return view('admin/auth/item-edit',compact('item','categories') );
    }
    public function update(Request $request, $id)
    {
    
        // 商品を取得
        $item = Item::find($id);
    
        // 商品画像の更新
        if ($request->hasFile('img_path')) {
            // 以前の画像を削除
            if ($item->img_path) {
                // 以前の画像のパスを取得して削除
                $imagePath = storage_path('app/public/' . $item->img_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
    
            // 新しい画像を保存
            $item->img_path = $request->file('img_path')->store('items', 'public');
        }
    
        // 商品情報の更新
        $item->name = $request->input('name');
        $item->memo = $request->input('memo');
        $item->price = $request->input('price');
        $item->category_id = $request->input('category_id');
    
        // 商品保存
        $item->save();
    
        // 編集後の商品一覧ページにリダイレクト
        return redirect()->route('admin.dashboard');
    }

    public function delete($id)
    {
        Item::find($id)->delete();
        return redirect()->route('admin.dashboard');
    }
    
}
