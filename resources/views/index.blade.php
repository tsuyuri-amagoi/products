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
    <form action="{{ route('products.index') }}" method="get" id="search-form">
      @csrf

      <div class="search-container">

        <label for="text" value="検索キーワード"></label>
        <input type="text" class="search keyword" id="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">

        <select name="maker_name" class="search maker_name" id="maker_name">
          <option value="">メーカー名</option>
          @foreach($companies as $company)
            <option value="{{ $company->company_name }}" {{ request('maker_name') == $company->company_name ? 'selected' : '' }}>
              {{ $company->company_name }}
            </option>
          @endforeach
        </select>

        <label for="min-price"></label>
        <input type="number" id="min-price" name="min-price" min="0" value="{{ request('min-price')}}" placeholder="最小価格">
        <label for="max-price"></label>
        <input type="number" id="max-price" name="max-price" min="0" value="{{ request('max-price')}}" placeholder="最大価格">

        <label for="min-stock"></label>
        <input type="number" id="min-stock" name="min-stock" min="0" value="{{ request('min-stock')}}" placeholder="最小在庫数">
        <label for="max-stock"></label>
        <input type="number" id="max-stock" name="max-stock" min="0" value="{{ request('max-stock')}}" placeholder="最大在庫数">

        <button type="submit" class="btn btn-search" id="search-btn">検索</button>

      </div>
    </form>

    <div class="list-item">
      <table>
        <thead>
          <tr>
            <th>@sortablelink('id', 'ID')</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>@sortablelink('price', '価格')</th>
            <th>@sortablelink('stock', '在庫数')</th>
            <th>メーカー名</th>
            <th colspan="2"><a href="{{ route('products.create') }}" class="new-btn">新規登録</a></th>
          </tr>
        </thead>
        <tbody id="searchResults">
        @forelse($products as $product)
          <tr>
            <td>{{ $product->id }}.</td>
            <td>
              <img class="product-image" src="{{ asset('storage/products/' . $product->img_path) }}" alt="商品画像" height="100%">
            </td>
            <td>{{ $product->product_name }}</td>
            <td>¥{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->company_name }}</td>
            <td>
              <a href="{{ route('products.show', $product->id) }}" class="detail-btn">詳細</a>
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

    <div class="pagination" id="paginationLinks">
      {{ $products->links() }}
    </div>
  </div>
</div>
@endsection