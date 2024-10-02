<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\Sale;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'img_path' ,
    ];

    public $sortable = ['id', 'price', 'stock'];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function sale() {
        return $this->hasMany(Sale::class, 'product_id', 'id');
    }

    public function getIndex(Request $request) {
        $q = Product::join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->sortable()
            ->orderBy('id', 'desc')
            ->orderBy('price', 'desc')
            ->orderBy('stock', 'desc');

        if($request->filled('keyword')) {
            $q->where(function($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->keyword. '%')
                ->orWhere('company_name', 'like', '%' . $request->keyword. '%');
            });
        }

        if($request->filled('maker_name')) {
            $q->where('company_name', $request->maker_name);
        }

        if($request->filled(['min-price', 'max-price'])) {
            $q->whereBetween('price', [$request->input('min-price'), $request->input('max-price')]);
        } elseif ($request->filled('min-price')) {
            $q->where('price', '>=', $request->input('min-price'));
        } elseif ($request->filled('max-price')) {
            $q->where('price', '<=', $request->input('max-price'));
        }

        if($request->filled(['min-stock', 'max-stock'])) {
            $q->whereBetween('stock', [$request->input('min-stock'), $request->input('max-stock')]);
        } elseif ($request->filled('min-stock')) {
            $q->where('stock', '>=', $request->input('min-stock'));
        } elseif ($request->filled('max-stock')) {
            $q->where('stock', '<=', $request->input('max-stock'));
        }

        $products = $q->paginate(5);
        $companies = Company::all();
        
        return [
            'products' => $products,
            'companies' => $companies,
        ];
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

        return [
            'product' => $product,
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
