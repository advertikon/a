var wishlistTimeout;

wishlist.add = function(product_id, product) {
	$(product).closest('.product-list').find('.notification, .notification-success').hide();
	clearTimeout(wishlistTimeout);
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
				//alert( json["success"].replace(/<[^>]*?>/g, "") );
				$(product).addClass('active');
				$(product).closest('.product-item').find('.notification-success').show();
				wishlistTimeout = setTimeout(function(){
					$(product).closest('.product-item').find('.notification-success').hide();
				}, 3000)
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			$(product).closest('.product-item').find('.notification').show();
			wishlistTimeout = setTimeout(function(){
				$(product).closest('.product-item').find('.notification').hide();
			}, 8000)
		}
	});
};

$( document ).delegate( ".to-favorites", "click", function( e ) {
	e.preventDefault();
	wishlist.add( $( this ).attr( "data-id" ), $( this ) );
} );

$( document ).delegate( ".to-favorites", "click", function( e ) {
	e.preventDefault();
	wishlist.add( $( this ).attr( "data-id" ) );
} );

$( document ).delegate( " .field-counter", "click", function() {
	$( this ).find( "input" ).trigger( "change" );
} );

$( document ).delegate( ".cart-sidebar .remove", "click", function( e ) {
	e.preventDefault();
	cart.remove( $( this ).closest( ".order-item" ).attr( "data-id" ) );
} );

$( document ).delegate( "#sidebar-cart-quantity", "change", function() {
	cart.update( $( this ).closest( ".order-item" ).attr( "data-id" ), $( this ).parent().find( "input" ).val() );
} );

$( document ).delegate( ".product-data .add-to-cart", "click", function( e ) {
	var
		me = $( this ),
		parent = me.closest( ".product-data" ),
		opt = {};

	e.preventDefault();

	opt[ parent.find( ".your-size" ).attr( "data-id" ) ] = parent.find( ".your-size" ).val();

	cart.add( {
		product_id: parent.attr( "data-id" ),
		quantity:    parent.find( ".product-quantity" ).val(),
		option:    opt
	}, function(){
		hidePopup( me.closest( ".popup" ).attr( "id" ) );
	} );
} );

$( document ).delegate( ".price-influence", "change", updatePrice );

// Cart add remove functions
cart = {
	add: function( data, cb ){
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: data,
			dataType: 'json',
			beforeSend: function() {

			},
			complete: function() {

			},
			success: function(json) {
				var total = 0;

				if (json['success']) {
					alert( json["success"].replace(/<[^>]*?>/g, "") );
					refreshCart();
					if ( typeof cb === "function" ) cb();
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	update: function( key, quantity, cb ) {
		var data = { quantity: {} };

		data.quantity[ key ] = quantity;

		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: data,
			dataType: 'json',
			beforeSend: function() {

			},
			complete: function( json ) {
				
			},
			success: function(json) {
				refreshCart();
				if ( typeof cb === "function" ) cb();
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	remove: function( key, cb ) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				
			},
			complete: function() {
				
			},
			success: function(json) {
				refreshCart();
				if ( typeof cb === "function" ) cb();
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

function refreshCart() {
	$( ".cart-sidebar" ).load( "/?route=common/cart/info", function(){
		$( "#cart-quantity" ).text( $( ".cart-sidebar-inner" ).attr( "data-quantity" ) );
	} );
}

function updatePrice() {
	var
		me = $( this ),
		parent = me.closest( ".product-data" ),
		opt = {};

	opt[ parent.find( ".your-size" ).attr( "data-id" ) ] = parent.find( ".your-size" ).val();

	parent.find( ".price-span" ).load( '/?route=product/product/price', {
		product_id: parent.attr( "data-id" ),
		quantity:    parent.find( ".product-quantity" ).val(),
		option:    opt
	} );
}