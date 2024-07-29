@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <h1>商品新規登録画面</h1>

      @if(session('success'))
          <div class="alert alert-success">
            {{ session('success')}}
          </div>
      @endif

      @if(session('error'))
          <div class="alert alert-error">
            {{ session('error')}}
          </div>
      @endif

      <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

          <div class="form-group">
            <label for="product_name">商品名</label>
            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="商品名" value="{{ old('product_name') }}">
            @if($errors->has('product_name'))
              <p>{{ $errors->first('product_name') }}</p>
            @endif
          </div>

          <div class="form-group">
            <label for="company_name">メーカー名</label>
            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="メーカー名" value="{{ old('company_name') }}">
            @if($errors->has('company_name'))
              <p>{{ $errors->first('company_name') }}</p>
            @endif
          </div>

          <div class="form-group">
            <label for="price">価格</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="価格" value="{{ old('price') }}">
            @if($errors->has('price'))
              <p>{{ $errors->first('price') }}</p>
            @endif
          </div>

          <div class="form-group">
            <label for="stock">在庫数</label>
            <input type="text" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ old('stock') }}">
            @if($errors->has('stock'))
              <p>{{ $errors->first('stock') }}</p>
            @endif
          </div>

          <div class="form-group">
            <label for="comment">コメント</label>
            <input type="text" class="form-control" id="comment" name="comment" placeholder="コメント" value="{{ old('comment') }}">
            @if($errors->has('comment'))
              <p>{{ $errors->first('comment') }}</p>
            @endif
          </div>

          <div class="form-group">
            <label for="img_path">商品画像</label>
            <input type="file" class="form-control" id="img_path" name="img_path" placeholder="商品画像" value="{{ old('img_path') }}">
            @if($errors->has('img_path'))
              <p>{{ $errors->first('img_path') }}</p>
            @endif
          </div>

          <button type="submit" class="btn btn-register">新規登録</button>
          
      </form>

          <a href=" {{ route('products.index') }} ">戻る</a>

  </div>
</div>
@endsection