@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="title">商品一覧画面</h1>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success')}}
    </div>
  @endif

  @if(session('danger'))
    <div class="alert alert-success">
      {{ session('danger')}}
    </div>
  @endif

  <div class="lists">
    <form action="{{ route('products.index') }}" method="get">
      @csrf
      <div class="search-container">
        <label for="text" value="検索キーワード"></label>
        <input type="text" class="search keyword" id="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">

        <select name="maker_name" class="search maker_name">
          <option value="">メーカー名</option>
          @foreach($companies as $company)
            <option value="{{ $company->company_name }}" {{ request('maker_name') == $company->company_name ? 'selected' : '' }}>
              {{ $company->company_name }}
            </option>
          @endforeach
        </select>

        <button type="submit" class="btn btn-search">検索</button>
      </div>
    </form>

    <div class="list-item">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            <th colspan="2"><a href="{{ route('products.create') }}" class="new-btn">新規登録</a></th>
          </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
          <tr>
            <td>{{ $product->id }}.</td>
            <td>
              <img src="{{ asset('storage/products/' . $product->img_path) }}" alt="商品画像" height="100%">
            </td>
            <td>{{ $product->product_name }}</td>
            <td>¥{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->company_name }}</td>
            <td>
              <a href="show/{{ $product->id }}" class="detail-btn">詳細</a>
            </td>
            <td>
              <form class="destroy-form" method="post" action="{{ route('products.destroy', $product->id)}}">
              @csrf
              @method('delete')
                <button type="submit" class="btn delete-btn">削除</button>
              </form>
            </td>
          </tr>

        @empty
          <tr>
              <td>該当する商品はありませんでした。</td>
          </tr>

        @endforelse
        </tbody>
      </table>
    </div>

    <div class="pagination">{{ $products->links() }}</div>
  </div>
</div>
@endsection