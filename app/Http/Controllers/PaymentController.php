<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller

{
    /**
     * 決済フォーム表示
     */
    public function create()
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
        return view('auth/payment',compact('totalPrice'));
    }
    /**
     * 決済実行
     */
    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => $request->totalPrice,
                'currency' => 'jpy',
            ]);

            
            $user = Auth::user();
            
            // 購入したアイテムを Purchase テーブルに挿入する
            $cartItems = Cart::where('user_id', $user->id)->with('item')->get();
            foreach ($cartItems as $cartItem) {
                Purchase::create([
                    'user_id' => $user->id,
                    'item_id' => $cartItem->item->id,
                    'quantity' => $cartItem->quantity,
                ]);
            }
            
            // カートのアイテムを削除する
            Cart::where('user_id', $user->id)->delete();

            
        } catch (Exception $e) {
            return back()->with('flash_alert', '決済に失敗しました！('. $e->getMessage() . ')');
        }
        return back()->with('status', '決済が完了しました！');
    }
}
