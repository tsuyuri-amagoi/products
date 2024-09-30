$(document).ready(function() {
    $('#search-btn').on('click', function() {
        var keyword = $('#text').val();
        var maker_name = $('#maker_name').val();
        var minPrice = $('#min-price').val();
        var maxPrice = $('#max-price').val();
        var minStock = $('#min-stock').val();
        var maxStock = $('#max-stock').val();

        $.ajax({
            type: 'GET',
            url: "{{ route('products.index') }}",
            data: {
                'text': keyword,
                'maker_name': maker_name,
                'min-price': minPrice,
                'max-price': maxPrice,
                'min-stock': minStock,
                'max-stock': maxStock,
            },
            success: function(response) {
                var html = '';
                if (response.products && response.products.length > 0) {
                    response.products.forEach(function(product) {
                        html += '<tr>';
                        html += '<td>' + product.id + '.</td>';
                        html += '<td><img class="product-image" src="{{ asset("storage/products/") }}/' + product.img_path + '" alt="商品画像" height="100%"></td>';
                        html += '<td>' + product.product_name + '</td>';
                        html += '<td>¥' + product.price + '</td>';
                        html += '<td>' + product.stock + '</td>';
                        html += '<td>' + product.company_name + '</td>';
                        html += '<td><a href="{{ route("products.show", "") }}/' + product.id + '" class="detail-btn">詳細</a></td>';
                        html += '<td><form class="destroy-form" method="post" action="{{ route("products.destroy", "") }}/' + product.id + '">@csrf @method("delete")<button type="submit" class="btn delete-btn">削除</button></form></td>';
                        html += '</tr>';
                    });
                } else {
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
    $('.destroy-form').on('submit', function(event) {
        event.preventDefault();
        var form = $(this);
        var url = form.attr('action');

        if(!confirm('本当に削除してもよろしいですか？')) {
            return false;
        }

        $.ajax({
            type: 'DELETE',
            url: url,
            data: form.serialize(),
            success: function(response) {
                if(response.success) {
                    form.closest('tr').remove();
                    alert(response.message)
                } else {
                    alert(response.message);
                }
            },
            error: function(xtr, status, error) {
                alert('削除に失敗しました')
                console.log('Error:', error);
            }
        });
    });
});