<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Company;

class ProductsController extends Controller
{
    public function index(Request $request) {

        $model = new Product;
        $query = $model->getIndex($request);

        $products = $query['products'];
        $companies = $query['companies'];

        return view('index', compact('products', 'companies'));
    }

    public function create() {
        $model = new product;
        $companies = $model->getCompanyId();

        return view('create', compact('companies'));
    }

    public function store(ProductRequest $request) {

        if($request->hasFile('img_path')) {
            $img_path = $request->file('img_path')->store('public/products');
            $img_path = basename($img_path);
        } else {
            $img_path = null;
        }

        $company = Company::firstOrCreate(['company_name' => $request->company_name]);
        
        DB::beginTransaction();

        try {
            $product = new Product;
            $product->registProduct($request, $img_path, $company);
            DB::commit();
            session()->flash('success', '登録しました。');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', '登録に失敗しました。');
            return back();
        }

        return redirect(route('products.create'));
    }

    public function show($id) {
        
        $model = new Product;
        $product = $model->getDetail($id);

        $product = $product['product'];

        return view('show', compact('product') );
    }

    public function edit($id) {

        $model = new Product;
        $productData = $model->getDetail($id);

        $product = $productData['product'];
        $companies = $productData['companies'];

        return view('edit', compact('product', 'companies'));
    }

    public function update(ProductRequest $request, $id) {

        if($request->hasFile('img_path')) {
            $img_path = $request->file('img_path')->store('public/products');
            $img_path = basename($img_path);
        } else {
            $img_path = $request->input('existing_img_path');
        }

        DB::beginTransaction();

        try {
            $model = new Product;
            $model->updateProduct($id, $request, $img_path);
            DB::commit();
            session()->flash('success', '更新しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('danger', '更新に失敗しました。');
            return back();
        };

        return redirect(route('products.edit', $id));
    }

    public function destroy($id) {

        DB::beginTransaction();

        try {
            $model = new Product;
            $product = $model->destroyPost($id);

            if ($product) {
                $product->delete();
                DB::commit();
                session()->flash('success', '削除しました。');
            } else {
                DB::rollBack();
                session()->flash('danger', '削除対象の商品が見つかりませんでした。');
                return back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('danger', '削除に失敗しました。');
            return back();
        };

        return redirect(route('products.index'));
    }
}
