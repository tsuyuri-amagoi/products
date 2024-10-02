<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function purchase(Request $request) {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);

        if($product->stock < $validated['quantity']) {
            return response()->json(['error' => '在庫が不足しています。'], 400);
        }

        DB::beginTransaction();

        try {
            $product->stock -= $validated['quantity'];
            $product->save();

            Sale::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);

            DB::commit();

            return response()->json(['message' => '購入が完了しました。'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => '購入処理中にエラーが発生しました。'], 500);
        }
    }
}
