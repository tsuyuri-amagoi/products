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

      <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

          <div class="form-group">
            <lavel for="product_name">商品名</lavel>
            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="商品名" value="{{ old('product_name') }}">
            @if($errors->has('product_name'))
              <p>{{ $errors->first('product_name') }}</p>
            @endif
          </div>

          <div class="form-group">
            <lavel for="company_id">メーカー名</lavel>
            <input type="text" class="form-control" id="company_id" name="company_id" placeholder="メーカー名" value="{{ old('company_id') }}">
            @if($errors->has('company_id'))
              <p>{{ $errors->first('company_id') }}</p>
            @endif
          </div>

          <div class="form-group">
            <lavel for="price">価格</lavel>
            <input type="text" class="form-control" id="price" name="price" placeholder="価格" value="{{ old('price') }}">
            @if($errors->has('price'))
              <p>{{ $errors->first('price') }}</p>
            @endif
          </div>

          <div class="form-group">
            <lavel for="stock">在庫数</lavel>
            <input type="text" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ old('stock') }}">
            @if($errors->has('stock'))
              <p>{{ $errors->first('stock') }}</p>
            @endif
          </div>

          <div class="form-group">
            <lavel for="comment">コメント</lavel>
            <input type="text" class="form-control" id="comment" name="comment" placeholder="コメント" value="{{ old('comment') }}">
            @if($errors->has('comment'))
              <p>{{ $errors->first('comment') }}</p>
            @endif
          </div>

          <div class="form-group">
            <lavel for="img_path">商品画像</lavel>
            <input type="file" class="form-control" id="img_path" name="img_path" placeholder="商品画像" value="{{ old('img_path') }}">
            @if($errors->has('img_path'))
              <p>{{ $errors->first('img_path') }}</p>
            @endif
          </div>

          <button type="submit" class="btn btn-register">新規登録</button>
          
      </form>

          <a href=" {{ route('products.index') }} ">戻る</button>

  </div>
</div>
@endsection