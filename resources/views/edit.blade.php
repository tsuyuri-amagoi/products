@extends('layouts.app')

@section('content')
<h1>商品情報編集画面</h1>

@if(session('success'))
  <div class="alert alert-success">
    {{ session('success')}}
  </div>
@endif

<form method="POST" action="{{ route('products.update', [ 'id' => $product->id ]) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div>
  <span>ID</span>
  <span>{{ $product->id }}</span>
</div>

<div>
  <lavel for="product_name">商品名</lavel>
  <input type="text" class="form-control" id="product_name" name="product_name" placeholder="商品名" value="{{ old('product_name', $product->product_name) }}">
</div>

<div>
  <lavel for="company_id">メーカー名</lavel>
  <input type="text" class="form-control" id="company_id" name="company_id" placeholder="メーカー名" value="{{ old('company_id', $product->company_id) }}">
</div>

<div>
  <lavel for="price">価格</lavel>
  <input type="text" class="form-control" id="price" name="price" placeholder="価格" value="{{ old('price', $product->price) }}">
</div>

<div>
  <lavel for="stock">在庫数</lavel>
  <input type="text" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ old('stock', $product->stock) }}">
</div>

<div>
  <lavel for="comment">コメント</lavel>
  <input type="text" class="form-control" id="comment" name="comment" placeholder="コメント" value="{{ old('comment', $product->comment) }}">
</div>

<div>
  <lavel for="img_path">商品画像</lavel>
  <input type="file" class="form-control" id="img_path" name="img_path">
  <input type="hidden" name="existing_img_path" value="{{ $product->img_path }}">
</div>

<button type="submit" class="btn btn-update">更新</button>
<a href="{{ route('products.show', $product->id) }}">戻る</a>
</form>
@endsection