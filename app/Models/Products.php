<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
            'product_name',
            'company_id',
            'price',
            'stock',
            'comment',
            'img_path' ,
    ];

    public function getSearch($request) {
        $keyword = $request->input('keyword');
        $maker_name = $request->input('maker_name');

        $products = DB::table('products');

        if(!empty($keyword)) {
            $products->where('product_name', 'like', '%'. $keyword. '%');
        }

        if(!empty($maker_name)) {
            $products->where('company_id', $maker_name);
        }

        $products = $products->paginate(5);

        return $products;
    }

    public function registProduct($request) {

        if($request->hasFile('img_path')) {
            $img_path = $request->file('img_path')->store('public/products');
            $request->img_path = basename($img_path);
        }

        DB::table('products')->insert([
            'product_name' => $request->product_name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $request->img_path,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function getDetail($id) {
        $details = DB::table('products')->where('id',$id)->first();

        return $details;
    }

    public function updateProduct($id, $request) {

        if($request->hasFile('img_path')) {
            $img_path = $request->file('img_path')->store('public/products');
            $request->img_path = basename($img_path);
        } else {
            $request->img_path = $request->input('existing_img_path');
        }

        DB::table('products')->where('id', $id)->update([
            'product_name' => $request->product_name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $request->img_path,
            'updated_at' => Carbon::now(),
        ]);
    }

    public function destroyPost($id) {
        return self::find($id);
    }
}
