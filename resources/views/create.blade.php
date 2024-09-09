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
            </div>
            @if($errors->has('product_name'))
              <p class="validation-error">{{ $errors->first('product_name') }}</p>
            @endif

            <div class="form-group">
              <label class="form-label" for="company_name">メーカー名<span>*</span></label>
              <select name="company_name" id="company_name" class="form-control">
                <option value=""></option>
                  @foreach($companies as $company)
                    <option value="{{ $company->company_name }}">
                      {{ $company->company_name }}
                    </option>
                  @endforeach
              </select>
            </div>
            @if($errors->has('company_name'))
              <p class="validation-error">{{ $errors->first('company_name') }}</p>
            @endif

            <div class="form-group">
              <label class="form-label" for="price">価格<span>*</span></label>
              <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
            </div>
            @if($errors->has('price'))
              <p class="validation-error">{{ $errors->first('price') }}</p>
            @endif

            <div class="form-group">
              <label class="form-label" for="stock">在庫数<span>*</span></label>
              <input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
            </div>
            @if($errors->has('stock'))
              <p class="validation-error">{{ $errors->first('stock') }}</p>
            @endif

            <div class="form-group">
              <label class="form-label" for="comment">コメント</label>
              <input type="text" class="form-control" id="comment" name="comment" value="{{ old('comment') }}">
            </div>
            @if($errors->has('comment'))
              <p class="validation-error">{{ $errors->first('comment') }}</p>
            @endif

            <div class="form-group">
              <label class="form-label" for="img_path">商品画像</label>
              <input type="file" class="form-control" id="img_path" name="img_path" value="{{ old('img_path') }}">
            </div>
            @if($errors->has('img_path'))
              <p class="validation-error">{{ $errors->first('img_path') }}</p>
            @endif

            <div class="form-group">
              <button type="submit" class="btn register-btn">新規登録</button>
              <a href=" {{ route('products.index') }} " class="back-btn">戻る</a>
            </div>
            
        </form>
      </div>
    </div>
@endsection