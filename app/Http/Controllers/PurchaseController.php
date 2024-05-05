<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $searchCategories = $request->input('search_categories');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // ログイン中の出品者のIDを取得
        $userId = Auth::id();

        $query = Purchase::query();

        // ログイン中の出品者の購入履歴を取得するクエリを構築
        $query->whereHas('item', function ($itemQuery) use ($userId) {
            $itemQuery->where('user_id', $userId);
        });

        if ($searchCategories) {
            $query->whereHas('item', function ($categoryQuery) use ($searchCategories) {
                $categoryQuery->where('category_id', $searchCategories);
            });
        }
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $values = $query->with(['item.category'])
            ->paginate(10)
            ->appends([
                'search_categories' => $searchCategories,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

        $totalPrice = $values->sum(function ($value) {
            return $value->item->price * $value->quantity;
        });

        return view('auth/purchase', compact('values', 'totalPrice', 'categories'));
    }
}


