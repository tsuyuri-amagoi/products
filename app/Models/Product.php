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
        if ($request->has('keyword') || $request->has('maker_name') || $request->has('min-price') || $request->has('max-price') || $request->has('min-stock') || $request->has('max-stock')) {
            session([
                'keyword' => $request->input('keyword'),
                'maker_name' => $request->input('maker_name'),
                'min-price' => $request->input('min-price'),
                'max-price' => $request->input('max-price'),
                'min-stock' => $request->input('min-stock'),
                'max-stock' => $request->input('max-stock'),
            ]);
        }

        $keyword = session('keyword', '');
        $maker_name = session('maker_name', '');
        $min_price = session('min-price', 0);
        $max_price = session('max-price', null);
        $min_stock = session('min-stock', 0);
        $max_stock = session('max-stock', null);

        $q = Product::join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->sortable()
            ->orderBy('id', 'desc')
            ->orderBy('price', 'desc')
            ->orderBy('stock', 'desc');

        if (!empty($keyword)) {
            $q->where(function($query) use ($keyword) {
                $query->where('product_name', 'like', '%' . $keyword . '%')
                        ->orWhere('company_name', 'like', '%' . $keyword . '%');
            });
        }

        if (!empty($maker_name)) {
            $q->where('company_name', $maker_name);
        }

        if (!empty($min_price) && !empty($max_price)) {
            $q->whereBetween('price', [$min_price, $max_price]);
        } elseif (!empty($min_price)) {
            $q->where('price', '>=', $min_price);
        } elseif (!empty($max_price)) {
            $q->where('price', '<=', $max_price);
        }

        if (!empty($min_stock) && !empty($max_stock)) {
            $q->whereBetween('stock', [$min_stock, $max_stock]);
        } elseif (!empty($min_stock)) {
            $q->where('stock', '>=', $min_stock);
        } elseif (!empty($max_stock)) {
            $q->where('stock', '<=', $max_stock);
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

// public function index(Request $request) {
//     $query = Product::query();

//     // 検索条件の適用
//     if ($request->filled('keyword')) {
//         $q->where(function($query) use ($keyword) {
//             $query->where('product_name', 'like', '%' . $keyword . '%')
//                     ->orWhere('company_name', 'like', '%' . $keyword . '%');
//         });
//     }
//     if ($request->filled('maker_name')) {
//         $query->where('company_name', $request->maker_name);
//     }
//     if ($request->filled('min-price')) {
//         $query->where('price', '>=', $request->min-price);
//     }
//     if ($request->filled('max-price')) {
//         $query->where('price', '<=', $request->max-price);
//     }
//     if ($request->filled('min-stock')) {
//         $query->where('stock', '>=', $request->min-stock);
//     }
//     if ($request->filled('max-stock')) {
//         $query->where('stock', '<=', $request->max-stock);
//     }

//     // ソート条件の適用
//     if ($request->filled('sort') && $request->filled('direction')) {
//         $query->orderBy($request->sort, $request->direction);
//     }

//     // ページネーションの取得
//     $products = $query->paginate(10);

//     // セッションに検索条件を保存
//     session([
//         'keyword' => $request->keyword,
//         'maker_name' => $request->maker_name,
//         'min-price' => $request->min-price,
//         'max-price' => $request->max-price,
//         'min-stock' => $request->min-stock,
//         'max-stock' => $request->max-stock,
//     ]);

//     return response()->json([
//         'products' => $products
//     ]);
// }