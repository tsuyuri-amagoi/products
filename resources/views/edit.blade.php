@extends('layouts.app')

@section('content')
<h1>商品情報編集画面</h1>

@if(session('success'))
  <div class="alert alert-success">
    {{ session('success')}}
  </div>
@endif

@if(session('danger'))
  <div class="alert alert-danger">
    {{ session('danger')}}
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
  <label for="product_name">商品名</label>
  <input type="text" class="form-control" id="product_name" name="product_name" placeholder="商品名" value="{{ old('product_name', $product->product_name) }}">
</div>

<div>
  <label for="company_name">メーカー名</label>
  <select name="company_name" id="company_name" class="form-control">
      @foreach($companies as $company)
          <option value="{{ $company->id }}" {{ $company->id == $product->company_id ? 'selected' : '' }}>
            {{ $company->company_name }}
          </option>
      @endforeach
    </select>
</div>

<div>
  <label for="price">価格</label>
  <input type="text" class="form-control" id="price" name="price" placeholder="価格" value="{{ old('price', $product->price) }}">
</div>

<div>
  <label for="stock">在庫数</label>
  <input type="text" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ old('stock', $product->stock) }}">
</div>

<div>
  <label for="comment">コメント</label>
  <input type="text" class="form-control" id="comment" name="comment" placeholder="コメント" value="{{ old('comment', $product->comment) }}">
</div>

<div>
  <label for="img_path">商品画像</label>
  <input type="file" class="form-control" id="img_path" name="img_path">
  <input type="hidden" name="existing_img_path" value="{{ $product->img_path }}">
  @if($product->img_path)
    <img src="{{ asset('storage/products/' . $product->img_path) }}" alt="アップロードされた画像ファイル" >
  @endif
</div>

<button type="submit" class="btn btn-update">更新</button>
<a href="{{ route('products.show', $product->id) }}">戻る</a>
</form>
@endsection