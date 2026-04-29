var baseurl = $('meta[name=base-url]').attr("content");
function addToCart(product_id){
    //var quantity = $('#quantity').val();
    $.ajax({
        method: "POST",
        url:  baseurl + "/addtocart",
        data: {quantity: 1, product_id: product_id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data.status == true) {
                toastr.success(data.message);
                $('#cart_count').html(data.cartCount);
            } else {
                toastr.error(data.message);
            }
            //$("html, body").animate({ scrollTop: 0 }, "slow");
        }
    });
}