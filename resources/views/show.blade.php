@extends('layouts.app')

@section('content')
<h1>商品情報詳細画面</h1>

<div>
  <span>ID</span>
  <span>{{ $product->id }}</span>
</div>

<div>
  <span>画像</span>
  <span><img src="{{ asset('storage/products/' . $product->img_path) }}" alt="アップロードされた画像ファイル" ></span>
</div>

<div>
  <span>商品名</span>
  <span>{{ $product->product_name }}</span>
</div>

<div>
  <span>メーカー</span>
  <span>{{ $product->company_id }}</span>
</div>

<div>
  <span>価格</span>
  <span>{{ $product->price }}</span>
</div>

<div>
  <span>在庫数</span>
  <span>{{ $product->stock }}</span>
</div>

<div>
  <span>コメント</span>
  <span>{{ $product->comment }}</span>
</div>

<a href="{{ route('products.edit', $product->id) }}" >編集</a> 
<a href="{{ route('products.index') }}" >戻る</a>
@endsection