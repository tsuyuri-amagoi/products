$(document).ready(function() {
    $('#search-btn').on('click', function(event) {
        event.preventDefault();

        var form = $('#search-form');
        var url = form.attr('action');

        var keyword = $('#text').val();
        var maker_name = $('#maker_name').val();
        var minPrice = $('#min-price').val();
        var maxPrice = $('#max-price').val();
        var minStock = $('#min-stock').val();
        var maxStock = $('#max-stock').val();

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'keyword': keyword,
                'maker_name': maker_name,
                'min-price': minPrice,
                'max-price': maxPrice,
                'min-stock': minStock,
                'max-stock': maxStock,
            },
            success: function(response) {
                console.log(response);
                var html = '';
                var products = response.products.data;

                if (products && products.length > 0) {

                    console.log('商品が見つかりました。:', products);
                    var html = products.map(function(product) {
                        var imageUrl = baseUrl + '/' + product.img_path;
                        var detailUrl = productUrls.show + '/' + product.id;
                        var destroyUrl = productUrls.destroy + '/' + product.id;

                        return '<tr>' +
                            '<td>' + product.id + '.</td>' +
                            '<td><img class="product-image" src="' + imageUrl + '" alt="商品画像" height="100%"></td>' +
                            '<td>' + product.product_name + '</td>' +
                            '<td>¥' + product.price + '</td>' +
                            '<td>' + product.stock + '</td>' +
                            '<td>' + product.company_name + '</td>' +
                            '<td><a href="' + detailUrl + '" class="detail-btn">詳細</a></td>' +
                            '<td><form class="destroy-form" method="POST" action="' + destroyUrl + '">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="btn delete-btn">削除</button></form></td>' +
                            '</tr>';
                    }).join('');
                } else {
                    console.log('該当商品がありません。');
                    html = '<tr><td colspan="8">該当する商品はありませんでした。</td></tr>';
                }
                $('#searchResults').html(html);
            },
            error: function(xhr, status, error) {
                console.error('エラー:', error);
                $('#searchResults').html('<tr><td colspan="8">検索に失敗しました。</td></tr>');
            }
        });
    });
});
                
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).on('submit', '.destroy-form', function(event) {
        event.preventDefault();
        var form = $(this);
        var url = form.attr('action');

        if (!confirm('本当に削除してもよろしいですか？')) {
            return false;
        }

        $.ajax({
            type: 'DELETE',
            url: url,
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    form.closest('tr').remove();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('削除に失敗しました');
                console.log('Error:', error);
            }
        });
    });
});