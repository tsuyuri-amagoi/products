<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Models\Products;

class ProductsController extends Controller
{
    public function index(Request $request) {
        $model = new Products();
        $products = $model->getSearch($request);

        return view('index', compact('products'));
    }

    public function create() {
        return view('create');
    }

    public function store(ProductRequest $request) {
        
        DB::beginTransaction();

        try {
            $model = new Products;
            $model->registProduct($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        session()->flash('success', '登録しました。');

        return redirect(route('products.create'));
    }

    public function show($id) {
        
        $model = new Products;
        $product = $model->getDetail($id);

        return view('show', compact('product') );
    }

    public function edit($id) {

        $model = new Products;
        $product = $model->getDetail($id);

        return view('edit', compact('product'));
    }

    public function update(ProductRequest $request, $id) {
        
        DB::beginTransaction();

        try {
            $model = new Products;
            $model->updateProduct($id, $request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back();
        };

        session()->flash('success', '更新しました。');

        return redirect(route('products.edit', $id));
    }

    public function destroy($id) {

        $model = new Products;
        $product = $model->destroyPost($id);
        $product->delete();
       
        session()->flash('success', '削除しました。');

        return redirect(route('products.index'));
    }
}
