var wishlistTimeout;

wishlist.add = function(product_id, product) {
	$(product).closest('.product-list').find('.notification, .notification-success').hide();
	clearTimeout(wishlistTimeout);

	if ( typeof isLogged != "undefined" && !isLogged ) {
		$(product).closest('.product-item').find('.notification').show();

		wishlistTimeout = setTimeout( function(){
			product.closest('.product-item').find('.notification').hide();
		}, 8000);

		return;
	}

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
		}
	});
};

$( document ).delegate( ".to-favorites", "click", function( e ) {
	e.preventDefault();
	wishlist.add( $( this ).attr( "data-id" ), $( this ) );
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

$( document ).delegate( ".your-size", "change", function() {
	var
		min = parseInt( $( this ).attr( "min" ), 10 ),
		max = parseInt( $( this ).attr( "max" ), 10 ),
		value = parseInt( $( this ).val(), 10 );

	if ( isNaN( value ) ) {
		if ( !isNaN( min ) ) {
			$( this ).val( min );

		} else if ( !isNaN( max ) ) {
			$( this ).val( max );
		}

		return;
	}

	if ( !isNaN( min ) && value < min ) {
		$( this ).val( min );
		alert( 'Value may not be less than ' + min );

	} else if ( !isNaN( max ) && value > max ) {
		$( this ).val( max );
		alert( 'Value may not be greater than ' + max );
	}

} );

$( document ).delegate( ".product-data .add-to-cart", "click", function( e ) {
	var
		me = $( this ),
		parent = me.closest( ".product-data" ),
		opt = {};

	e.preventDefault();

	parent.find( ".your-size" ).each( function() {
		opt[ $( this ).attr( "data-id" ) ] = $( this ).val();
	} );

	cart.add( {
		product_id: parent.attr( "data-id" ),
		quantity:   parent.find( ".product-quantity" ).val(),
		option:     opt,
		price:      $( ".constructor-total-price i" ).text(),
		weight:     $( ".constructor-total-weight i" ).text(),
		json:       typeof canvas === "object" ? saveJSON() : "",
		image:      typeof canvas === "object" ? canvas.toDataURL() : "",
		name:       $( "#product-name" ).val(),
		save:       typeof window.isSaveDesign === "undefined" ? '0' : window.isSaveDesign
	}, function( ret ){
		hidePopup( me.closest( ".popup" ).attr( "id" ) );

		if ( ret.product_id ) {
			parent.attr( "data-id", ret.product_id );
		} 
	} );
} );

$( document ).delegate( ".saved-remove", "click", function( e ) {
	var
		me = $( this ),
		parent = me.closest( ".product-data" ),
		opt = {};

	e.preventDefault();

	$.post( '/?route=account/designs/remove', {
		product_id: parent.attr( "data-id" )
	}, function( ret ){
		me.closest( ".product-item" ).remove();
	} );
} )

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
					// alert( json["success"].replace(/<[^>]*?>/g, "") );
					refreshCart();
					if ( typeof cb === "function" ) cb( json );
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

$( document ).ready( function() {
	$( ".quick-view" ).appendTo( $("body") );
} );

$( document ).delegate( ".parts-toggler", "click", function( e ){ e.stopPropagation(); } );

function customizeControls(){
  fabric.Canvas.prototype.customiseControls({
    tl: {
        action: 'remove',
        cursor: 'pointer',
    },
    tr: {
        action: 'rotate',
        cursor: 'crosshair'
    }
  }, function() {
      canvas.renderAll();
  });

  fabric.Object.prototype.customiseCornerIcons({
    settings: {
        borderColor: '#ffdcf4',
        cornerSize: 40,
        cornerBackgroundColor: '#d13ca3',
        cornerShape: 'circle',
        cornerPadding: 15,
    },
    tr: {
      icon: 'image/arbole/rotate.svg',
    },
    tl: {
      icon: 'image/arbole/remove.svg',
    }
  }, function() {
      canvas.renderAll();
  });

  fabric.Group.prototype._controlsVisibility = {
    mt: false, 
    mb: false, 
    ml: false, 
    mr: false, 
    bl: false,
    br: false,
    mtr: false,
    tr: true,
    tl: true
  };
}