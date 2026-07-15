var baseurl = $('meta[name=base-url]').attr("content");
function addToCart(product_id, purchase_type, plan){
    //var quantity = $('#quantity').val();
    $('#add_to_cart_button_' + product_id).html('Adding...');
    $('#add_to_cart_button_' + product_id).attr('disabled', true);
    $.ajax({
        method: "POST",
        url:  baseurl + "/addtocart",
        // purchase_type / plan default for normal products; consumed by the cart from Phase 3 on.
        data: {quantity: 1, product_id: product_id, purchase_type: purchase_type || 'one_time', plan: plan || ''},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data.status == true) {
                toastr.success(data.message);
                $('#cart_count').html(data.cartCount);
                $('#add_to_cart_button_' + product_id).html(data.message);
                $('#add_to_cart_button_' + product_id).attr('disabled', false);
            } else {
                toastr.error(data.message);
                $('#add_to_cart_button_' + product_id).html('Add to Cart');
                $('#add_to_cart_button_' + product_id).attr('disabled', false);
            }
            //$("html, body").animate({ scrollTop: 0 }, "slow");
        },
        error: function () {
            toastr.error('Error adding product to cart');
            $('#add_to_cart_button_' + product_id).html('Add to Cart');
            $('#add_to_cart_button_' + product_id).attr('disabled', false);
        }
    });
}