@extends('layouts.app')

@section('content')
<h1>商品一覧画面</h1>

@if(session('success'))
  <div class="alert alert-success">
    {{ session('success')}}
  </div>
@endif

 <form action="{{ route('products.index') }}" method="get">
  @csrf

  <label for="text"></label>
  <input type="text" class="keyword" id="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">

  <select name="maker_name">
    <option value="">選択無し</option>
    @foreach($products->unique('company_id') as $product)
      <option value="{{ $product->company_id }}"
      {{ request('maker_name') == $product->company_id ? 'selected' : '' }}>
        {{ $product->company_id }}
      </option>
    @endforeach
  </select>

  <button type="submit" class="btn btn-search" >検索</button>

 </form>

<div class="lists">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫数</th>
        <th>メーカー名</th>
        <th><a href="{{ route('products.create') }}">新規登録</a></th>
      </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
      <tr>
        <td>{{ $product->id }}</td>
        <td><img src="{{ asset('storage/products/' . $product->img_path) }}" alt="アップロードされた画像ファイル" ></td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->company_id }}</td>
        <td><a href="show/{{ $product->id }}">詳細</a></td>
        <form method="post" action="{{ route('products.destroy', $product->id)}}">
        @csrf
        @method('delete')
        <td><button type="submit" class="btn btn-delete">削除</button></td>
        </form>
      </tr>

    @empty
      <tr>
          <td>該当する商品はありませんでした。</td>
      </tr>

    @endforelse
    </tbody>
  </table>
</div>

<div>{{ $products->links() }}</div>

@endsection