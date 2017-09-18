"use strict";

var C = function() {
	var
		category = window.localStorage.getItem( 'cCategory' ),
		subcategory = window.localStorage.getItem( 'cSubcategory' ),
		product_name = window.localStorage.getItem( 'cProductName' ),

		categoryInputName = ".input-category",
		subcategoryInputName = ".input-subcategory",
		productName = "#product-name",

		categoryButtonName = ".go-to-category",
		subcategoryButtonName = ".go-to-subcategory";

	$( document ).ready( function() {
		if ( category ) {
			$( categoryInputName ).each( function(){
				var el = this;
				if ( $( this ).val() == category ) {
					setTimeout(
						function(){
							el.click();
						},
						1000
					);
					return;
				}
			} );

			editMode();
		}

		if ( subcategory ) {
			$( subcategoryInputName ).each( function(){
				var el = this;
				if ( $( this ).val() == subcategory ) {
					setTimeout(
						function(){
							el.click();
						},
						1000
					);
					return;
				}
			} );
		}

		if ( product_name ) {
			$( productName ).val( product_name );
		}

	} );

	$( document ).delegate( categoryInputName, "change", setCategory );
	$( document ).delegate( subcategoryInputName, "change", setSubcategory );
	$( document ).delegate( productName, "change", setProductName );

	$( document ).delegate( categoryButtonName, "click", goToCategory );
	$( document ).delegate( subcategoryButtonName, "click", goToSubcategory );

	function setCategory(){
		var t = null;

		if ( typeof this !== "undefined" ) {
			t = $( this ).val();

			if ( t === category ) return;

			category = t;
			window.localStorage.setItem( 'cCategory', category );

		} else {
			category = null;
			window.localStorage.removeItem( 'cCategory' );
		}

		setSubcategory.call();
	}

	function setSubcategory(){
		var t = null;

		if ( typeof this !== "undefined" ) {
			t = $( this ).val();

			if ( t === subcategory ) return;

			subcategory = t;
			window.localStorage.setItem( 'cSubcategory', subcategory );

		} else {
			subcategory = null;
			window.localStorage.removeItem( 'cSubcategory' );
		}
	}

	function setProductName(){
		var t = null;

		if ( typeof this !== "undefined" ) {
			t = $( this ).val();

			if ( t === product_name ) return;

			product_name = t;
			window.localStorage.setItem( 'cProductName', product_name );
			
		} else {
			product_name = null;
			window.localStorage.setRemove( 'cProductName' );
		}
	}

	function goToCategory( e ) {
		var o;

		e.preventDefault();

		o = parseQuery();
		o.route = 'constructor/step1';
		window.location.assign( window.location.protocol + "//" + window.location.host + window.location.pathname + makeQuery( o ) );

		return false;
	};

	function goToSubcategory( e ) {
		var o;

		e.preventDefault();

		if ( category ) {
			o = parseQuery();
			o.route = 'constructor/step2';
			o.id = category;
			window.location.assign( window.location.protocol + "//" + window.location.host + window.location.pathname + makeQuery( o ) );
		}

		return false;
	};

	function parseQuery() {
		var
			q = window.location.search,
			o = {};

		if ( q[ 0 ] == "?" ) {
			q = q.substr( 1 );
		}

		$.each( q.split( "&" ), function(){
			var parts = this.split( "=" );

			if ( parts[ 0 ] && parts[ 1 ] ) {
				o[ parts[ 0 ] ] = parts[ 1 ];
			}
		} );

		return o;
	}

	function makeQuery( o ) {
		var
			q = "",
			temp = [];

		for( var i in o ) {
			if ( o.hasOwnProperty( i ) ) {
				temp.push( window.encodeURIComponent( i ) + "=" + window.encodeURIComponent( o[ i ] ) );
			}
		}

		if ( temp.length ) {
			q = "?" + temp.join( "&" );
		}

		return q;
	}

	function editMode() {
		$( ".jewelery-name" ).show();
		$( ".constructor-title" ).hide();
	}
}

window.c = new C();