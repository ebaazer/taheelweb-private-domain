// open multiple popup
jQuery(document).on('show.bs.modal', '.modal', function (event) {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function () {
        jQuery('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

// Add product in bag
jQuery(document).on('click', 'button.add-to-cart', function () {
    var productID = jQuery(this).data('productid');
    jQuery.ajax({
        url: url + 'cart/add',
        type: 'post',
        data: {productID: productID},
        dataType: 'json',
        beforeSend: function () {
            jQuery('button.add-to-cart1').button('loading');
        },
        complete: function () {
            jQuery('button.add-to-cart').button('reset');
        },
        success: function (json) {            
            jQuery('span#update-cart-bag').html(json.bagItem);
            jQuery("ul#go-to-basket").html('');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Cart update
jQuery(document).on('click', 'button.update-cart', function () {
    var productID = jQuery(this).data('updproductid');
    var itemID = jQuery(this).data('itemid');
    var qty = jQuery('#qty' + itemID).val();
    jQuery.ajax({
        url: url + 'cart/update',
        type: 'post',
        data: {productID: productID, qty: qty},
        dataType: 'json',
        beforeSend: function () {
            jQuery('button#update-cart' + productID).button('loading');
        },
        complete: function () {
            jQuery('button#update-cart' + productID).button('reset');
        },
        success: function (json) {
            jQuery('#qty' + itemID).val(qty);
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});


// Cart remove
jQuery(document).on('click', 'button.remove-cart', function () {
    var productID = jQuery(this).data('rmproductid');
    var itemID = jQuery(this).data('rmitemid');
    jQuery.ajax({
        url: url + 'cart/remove',
        type: 'post',
        data: {productID: productID},
        dataType: 'json',
        beforeSend: function () {
            jQuery('button#remove-cart' + productID).button('loading');
        },
        complete: function () {
            jQuery('button#remove-cart' + productID).button('reset');
        },
        success: function (json) {
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

