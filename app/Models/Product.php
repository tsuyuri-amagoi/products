<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
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

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getIndex($request) {
        $q = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name');

        if(!empty($request->keyword)) {
            $q->where('product_name', 'like', '%' . $request->keyword. '%');
        }

        if(!empty($request->maker_name)) {
            $q->where('company_name', $request->maker_name);
        }
        
        $companies = DB::table('companies')->get();
        $products = $q->paginate(5);
        
        return [
            'products' => $products,
            'companies' => $companies,
        ];
    }

    public function getCompanyId() {
        $companies = DB::table('companies')->get();

        return $companies;
    }

    public function registProduct($request, $img_path, $company) {

        DB::table('products')->insert([
            'product_name' => $request->product_name,
            'company_id' => $company->id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $img_path
        ]);
    }

    public function getDetail($id) {
        $product = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->where('products.id', $id)
        ->select('products.*', 'companies.company_name', 'companies.id as company_id')
        ->first();

        $companies = DB::table('companies')->get();

        return [
            'product' => $product,
            'companies' => $companies
        ];
    }

    public function updateProduct($id, $request, $img_path) {

        DB::table('products')->where('id', $id)->update([
            'product_name' => $request->product_name,
            'company_id' => $request->company_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $img_path
        ]);
    }

    public function destroyPost($id) {
        return self::find($id);
    }
}
