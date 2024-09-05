@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="title">商品情報編集画面</h1>

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

  <div class="lists edit-container">
    <form method="POST" action="{{ route('products.update', [ 'id' => $product->id ]) }}" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="form-group">
      <table>
        <tbody>
          <tr>
            <td>ID</td>
            <td>{{ $product->id }}.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="form-group">
      <label class="form-label" for="product_name">商品名<span>*</span></label>
      <input type="text" class="form-control" id="product_name" name="product_name" placeholder="商品名" value="{{ old('product_name', $product->product_name) }}">
    </div>
    @if($errors->has('product_name'))
      <p class="validation-error">{{ $errors->first('product_name') }}</p>
    @endif

    <div class="form-group">
      <label class="form-label" for="company_name">メーカー名<span>*</span></label>
      <select name="company_name" id="company_name" class="form-control">
          @foreach($companies as $company)
              <option value="{{ $company->id }}" {{ $company->id == $product->company_id ? 'selected' : '' }}>
                {{ $company->company_name }}
              </option>
          @endforeach
        </select>
    </div>

    <div class="form-group">
      <label class="form-label" for="price">価格<span>*</span></label>
        
      <input type="text" class="form-control" id="price" name="price" placeholder="価格" value="{{ old('price', $product->price) }}">
    </div>
    @if($errors->has('price'))
      <p class="validation-error">{{ $errors->first('price') }}</p>
    @endif

    <div class="form-group">
      <label class="form-label" for="stock">在庫数<span>*</span></label>
      <input type="text" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ old('stock', $product->stock) }}">
    </div>
    @if($errors->has('stock'))
      <p class="validation-error">{{ $errors->first('stock') }}</p>
    @endif

    <div class="form-group">
      <label class="form-label" for="comment">コメント</label>
      <input type="text" class="form-control" id="comment" name="comment" placeholder="コメント" value="{{ old('comment', $product->comment) }}">
    </div>

    <div class="form-group">
      <label class="form-label" for="img_path">商品画像</label>
      <input type="file" class="form-control" id="img_path" name="img_path">
      <input type="hidden" name="existing_img_path" value="{{ $product->img_path }}">

      <!-- 
      @if($product->img_path)
        <img src="{{ asset('storage/products/' . $product->img_path) }}" alt="アップロードされた画像ファイル" >
      @endif
      -->

    </div>
    <div class="form-group">
      <button type="submit" class="btn update-btn">更新</button>
      <a href="{{ route('products.show', $product->id) }}" class="back-btn">戻る</a>
    </div>

    </form>
  </div>
</div>
@endsection