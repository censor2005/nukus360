$(document).ready(function(){
        
    $(".add-to-cart button").click(function(){
        var btn = $(this);
        var prod_id = $(this).parent().attr('data-id');
        //alert(prod_id);
        
        btn.text("Обработка...");
        btn.attr('disabled', 'disabled');
        
        var sizes = $('input:checked');
        
        $.each(sizes, function(key, value){
            var item_size = sizes[key].value;
            var request_params = {id:prod_id, qty:1, size:item_size};
            $.post(
                "/ru/cart/add_to_cart", 
                request_params, 
                function(data,status){
                    btn.text("Добавить в корзину");
                    btn.removeAttr('disabled');
                    var total = parseInt(data.total);
                    var total_items = data.total_items;
                    $("#cart_total").text(total);
                }, "json"
            );

        });
        return true;
    });
});