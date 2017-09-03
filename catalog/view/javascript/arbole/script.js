wishlist.add = function(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.alert-dismissible').remove();

			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['success']) {
				alert( json["success"].replace(/<[^>]*?>/g, "") );
				// $('#content').parent().before('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			// $('#wishlist-total span').html(json['total']);
			// $('#wishlist-total').attr('title', json['total']);

			// $('html, body').animate({ scrollTop: 0 }, 'slow');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};

$( document ).delegate( ".to-favorites", "click", function( e ) {
	e.preventDefault();
	wishlist.add( $( this ).attr( "data-id" ) );
} );

$( document ).delegate( ".product-data .add-to-cart", "click", function( e ) {
	var me = $( this );

	e.preventDefault();

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + $( this ).closest( ".product-data" ).attr( "data-id" ) + '&quantity=' + $( this ).closest( ".product-data" ).find( ".product-quantity" ).val() + '&option[' + $( this ).closest( ".product-data" ).find( ".your-size" ).attr( "data-id" ) + ']=' + $( this ).closest( ".product-data" ).find( ".your-size" ).val(),
		dataType: 'json',
		beforeSend: function() {
			$('#cart > button').button('loading');
		},
		complete: function() {
			$('#cart > button').button('reset');
		},
		success: function(json) {
			var total = 0;

			$('.alert-dismissible, .text-danger').remove();

			// if (json['redirect']) {
			// 	location = json['redirect'];
			// }

			if (json['success']) {
				hidePopup( me.closest( ".popup" ).attr( "id" ) );
				$( "#cart-quantity" ).text( json.total.replace( /^(\d+).*/g, "$1") );
				alert( json["success"].replace(/<[^>]*?>/g, "") );
				// $('#content').parent().before('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// // Need to set timeout otherwise it wont update the total
				// setTimeout(function () {
				// 	$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				// }, 100);

				// $('html, body').animate({ scrollTop: 0 }, 'slow');

				// $('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
} );