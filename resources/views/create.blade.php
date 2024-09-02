@extends('layouts.app')

@section('content')
  <div class="container">
    <h1 class="title">商品新規登録画面</h1>

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


      <div class="lists list-container">
        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
          @csrf

            <div class="form-group">
              <label class="form-label" for="product_name">商品名<span>*</span></label>
              <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}">
              @if($errors->has('product_name'))
                <p>{{ $errors->first('product_name') }}</p>
              @endif
            </div>

            <div class="form-group">
              <label class="form-label" for="company_name">メーカー名<span>*</span></label>
              <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}">
              @if($errors->has('company_name'))
                <p>{{ $errors->first('company_name') }}</p>
              @endif
            </div>

            <div class="form-group">
              <label class="form-label" for="price">価格<span>*</span></label>
              <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
              @if($errors->has('price'))
                <p>{{ $errors->first('price') }}</p>
              @endif
            </div>

            <div class="form-group">
              <label class="form-label" for="stock">在庫数<span>*</span></label>
              <input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
              @if($errors->has('stock'))
                <p>{{ $errors->first('stock') }}</p>
              @endif
            </div>

            <div class="form-group">
              <label class="form-label" for="comment">コメント</label>
              <input type="text" class="form-control" id="comment" name="comment" value="{{ old('comment') }}">
              @if($errors->has('comment'))
                <p>{{ $errors->first('comment') }}</p>
              @endif
            </div>

            <div class="form-group">
              <label class="form-label" for="img_path">商品画像</label>
              <input type="file" class="form-control" id="img_path" name="img_path" value="{{ old('img_path') }}">
              @if($errors->has('img_path'))
                <p>{{ $errors->first('img_path') }}</p>
              @endif
            </div>

            <div class="form-group">
              <button type="submit" class="btn register-btn">新規登録</button>
              <a href=" {{ route('products.index') }} " class="back-btn">戻る</a>
            </div>
            
        </form>
      </div>
    </div>
@endsection