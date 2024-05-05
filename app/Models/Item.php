<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'memo',
        'category_id',
        'img_path',
        'admin_id',
    ];

    
    public function insertItem($request){

        $imageDirectory = 'public/images';

        

        $item = $this->create([
            'name' => $request->name,
            'price' => $request->price,
            'memo' => $request->memo,
            'category_id' => $request->category_id,
            'img_path' => '',
            'admin_id' => Auth::id(),
        ]);

        if ($request->hasFile('img_path') && $request->file('img_path')->isValid()) {
            // 画像を保存
            $path = $request->file('img_path')->store($imageDirectory);

            // データベースの画像パスを更新
            $item->update(['img_path' => $path]);
        }

        return $item;
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }


    
}



