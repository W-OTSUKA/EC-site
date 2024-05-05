<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('item')->get();

        $totalPrice = $cartItems->sum(function ($cartItem) {
        // カート内の各アイテムに対してこの無名関数が適用される
        // $cartItem は各アイテムを表す
        // $cartItem->item でカート内のアイテム自体を取得し、その price プロパティで価格を取得
        // $cartItem->quantity でカート内のアイテムの数量を取得
        // 価格と数量を掛けて各アイテムの合計金額を計算し、それらの合計を sum() メソッドが返す
            return $cartItem->item->price * $cartItem->quantity;
        });

        return view('auth/cart',compact('cartItems','totalPrice'));
    }

    public function addCart(Request $request,$itemId)
    {
        // カートに追加するアイテムを取得
        $item = Item::find($itemId);
        
        // カートにアイテムがない場合は新しく作成し、数量を増やす
        
        Cart::updateOrCreate(
            ['item_id' => $item->id],
            [
                'user_id' => auth()->user()->id,
                'quantity' => Cart::raw('quantity + 1') // 既存の数量に1を加える
            ]
        );
        return redirect()->route('dashboard');
    }


    public function delete($id)
    {
        Cart::find($id)->delete();
        return redirect()->route('cart');
    }


}
