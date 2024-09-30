@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="title">商品情報詳細画面</h1>

  <div class="lists edit-container">
    <table>
      <tbody>
          <tr>
            <td>ID</td>
            <td>{{ $product->id }}.</td>
          </tr>

        <tr>
          <td>画像</td>
          <td><img src="{{ asset('storage/products/' . $product->img_path) }}" alt="アップロードされた画像ファイル" height="800%"></td>
        </tr>

        <tr>
          <td>商品名</td>
          <td>{{ $product->product_name }}</td>
        </tr>

        <tr>
          <td>メーカー</td>
          <td>{{ $product->company_name }}</td>
        </tr>

        <tr>
          <td>価格</td>
          <td>{{ $product->price }}</td>
        </tr>

        <tr>
          <td>在庫数</td>
          <td>{{ $product->stock }}</td>
        </tr>

        <tr>
          <td>コメント</td>
          <td>{{ $product->comment }}</td>
        </tr>

        <tr>
          <td colspan="2" class="btn-container">
            <a href="{{ route('products.edit', $product->id) }}" class="edit-btn">編集</a>
            <a href="{{ route('products.index') }}" class="back-btn">戻る</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection