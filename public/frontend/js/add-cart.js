$(document).ready(function() {
   
    getCartQty();
    function getCartQty(){
        $.ajax({
            url: '/getCartQty',
            method: 'get',
            data:{
            },
            success:function(data){
                var template='';
                $('.quantity-cart-psa').text(data.length);
                if(data.length==0){
                    template+='<div class="cart-empty">';
                    template+='<img src="/../frontend/img/no_cart.png" alt="">';
                    template+='</div>';
                }
                var total=0;
                for(var i=0; i<data.length;i++){
                    var price_product= data[i].product_sale_price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                    var subtotal = (data[i].product_qty) * data[i].product_sale_price;
                    total += subtotal;

                    template+='<div class="single_product cart-item flex">'
                    template+='	<div class="img-product"><img src="../../storage/'+data[i].product_thumbnail+'" alt="" /></div>'
                    template+='	<div class="cart-content">'
                    template+='		<p class="name_product">'+data[i].product_name+'</p>'
                    template+='		<div class="cart-conten--info flex">'
                    template+='			<p class="product-price">'+price_product+' đ</p>'
                    template+='			<p class="quantity">x '+data[i].product_qty+'</p>'
                    // template+='			<a href="/delete-product/'+data[i].session_id+'" class="delete">Xóa</a>'
                    template+='		</div>'
                    template+='	</div>'
                    template+='</div>'
                }
                total= total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                var template1='<p class="total-money">Tổng:'+total+' <span > đ</span></p>'
                $('.all-cart').html("");
                $('.total-money1').html("");
                
                $('.all-cart').append(template);
                if(data.length>0){
                    $('.total-money1').append(template1);
                }
            }
        });
    }

    // $('.btn_checkout').click(function() {
    //     swal({
    //         title: "Xác nhận đặt hàng",
    //         text: "Đơn hàng sau khi đặt sẽ không thể thay đổi thông tin, bạn có muốn đặt hàng không?",
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonClass: "btn-danger",
    //         confirmButtonText: "Đặt hàng!",
    //         cancelButtonText: "Không, chờ đã!",
    //         closeOnConfirm: false,
    //         closeOnCancel: false
    //       },
    //       function(isConfirm) {
    //         if (isConfirm) {
    //             var name = $('.shipping_name').val();
    //             var address = $('.shipping_address').val();
    //             var phone = $('.shipping_phone').val();
    //             var email = $('.shipping_email').val();
    //             var notes = $('.shipping_notes').val();
    //             var customer_id = $('.customer_id').val();
    //             var total_order = $('.total_order').val();
    //             var _token = $('input[name="_token"]').val();
    //             var payment_method =$('input[name=payment_method]:checked', '.check_out-form').val();
    //             var feeship = 50000;
    //             $.ajax({
    //                 url: '/checkout-order',
    //                 method: 'POST',
    //                 data:{
    //                     _token:_token,name:name, address:address, phone:phone, email:email, notes:notes, feeship:feeship,customer_id:customer_id,total_order:total_order,payment_method:payment_method
    //                 },
    //                 success:function(res){
    //                     swal("Đơn hàng!", "Đơn hàng của bạn đã được gửi đi thành công!", "success");

    //                 }
    //             });
    //             window.setTimeout(function(){
    //                 window.location.href = '/confirmation';
    //             },3000);
    //         } else {
    //           swal("Đóng", "Đơn hàng của bạn chưa được gửi, làm ơn hoàn tất đơn hàng :)", "error");
    //         }
    //       });
        
    // });

    $('.add-to-cart').click(function() {
        var id = $(this).data('id_product');
        var cart_product_id = $('.cart_product_id_' + id).val();
        var cart_product_name = $('.cart_product_name_' + id).val();
        var cart_product_thumbnail = $('.cart_product_thumbnail_' + id).val();
        var cart_product_sale_price = $('.cart_product_sale_price_' + id).val();
        var cart_product_qty = $('.cart_product_qty_' + id).val();
        var cart_product_quantity = $('.cart_product_quantity_' + id).val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/add-cart-ajax',
            method: 'POST',
            data:{
                cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_thumbnail:cart_product_thumbnail,cart_product_sale_price:cart_product_sale_price,cart_product_qty:cart_product_qty,cart_product_quantity:cart_product_quantity,_token:_token
            },
            success:function(data){
                getCartQty();
                swal({
                        title: "Đã thêm sản phẩm vào giỏ hàng",
                        text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                        showCancelButton: true,
                        cancelButtonText: "Xem tiếp",
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Đi đến giỏ hàng",
                        closeOnConfirm: false
                    },
                    function() {
                        window.location.href = '/cart';
                    });
            }
        });
    });

    $('.like_us').click(function(){
        var _token = $('input[name="_token"]').val();
        var product_id = $(this).data('wishlish_product_id');
        var user_id = $('.wishlist_user_id').val()
        $.ajax({
            url: '/wishlish',
            type: 'POST',
            data:{
                product_id:product_id,_token:_token,user_id:user_id
            },
            success:function(response){
                console.log(response);
                if(response.action =='add'){
                    $('.like_us').children().css('color','red');
                    $('.like_us').css('background','pink');
                    swal("Thông báo!", response.message, "success");
                }else if(response.action =='remove')
                $('.like_us').children().css('color','black');
                swal("Thông báo!",response.message, "success");
            }
        });
    });
});
