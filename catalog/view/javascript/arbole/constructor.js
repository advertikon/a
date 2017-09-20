"use strict";

var C = function() {
	var
		category = window.localStorage.getItem( 'cCategory' ),
		subcategory = window.localStorage.getItem( 'cSubcategory' ),
		product_name = window.localStorage.getItem( 'cProductName' ),
		product = window.localStorage.getItem( 'cProduct' ),

		categoryInputName = ".input-category",
		subcategoryInputName = ".input-subcategory",
		productName = "#product-name",
		productInputName = ".input-product",
		step3ProductName = ".product-list",
		step3FilterName = ".filter-page",
		step3FilterWrapperName = ".filters-wrapper",

		step1ButtonName = ".go-to-step1",
		step2ButtonName = ".go-to-step2",
		step3ButtonName = ".go-to-step3",
		step4ButtonName = ".go-to-step4",
		step5ButtonName = ".go-to-step5",

		isEditMode = false,
		clickDelay = 200;

	$( document ).ready( function() {
		if ( category ) {
			$( categoryInputName ).each( function(){
				var el = this;
				if ( $( this ).val() == category ) {
					setTimeout(	function(){	el.click();	}, clickDelay	);
					return;
				}
			} );

			isEditMode = true;
		}

		if ( subcategory ) {
			$( subcategoryInputName ).each( function(){
				var el = this;
				if ( $( this ).val() == subcategory ) {
					setTimeout(	function(){	el.click();	}, clickDelay	);
					return;
				}
			} );

			isEditMode = true;
		}

		if ( product_name ) {
			$( productName ).val( product_name );
			isEditMode = true;
		}

		if ( product ) {
			initProduct();
			isEditMode = true;
		}

		if ( isEditMode ) {
			editMode();
		}

	} );

	$( document ).delegate( categoryInputName, "change", setCategory );
	$( document ).delegate( subcategoryInputName, "change", setSubcategory );
	$( document ).delegate( productName, "change", setProductName );
	$( document ).delegate( productInputName, "change", setProduct );

	$( document ).delegate( step1ButtonName, "click", goToStep1 );
	$( document ).delegate( step2ButtonName, "click", goToStep2 );
	$( document ).delegate( step3ButtonName, "click", goToStep3 );
	$( document ).delegate( step4ButtonName, "click", goToStep4 );
	$( document ).delegate( step5ButtonName, "click", goToStep5 );

	$( document ).delegate( step3FilterName, "change", filter );

	function initProduct() {
		$( productInputName ).each( function(){
			var el = this;
			if ( $( this ).val() == product ) {
				setTimeout(	function(){	el.click();	}, clickDelay	);
				return;
			}
		} );
	}

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

		setSubcategory();
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

		setProduct();
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

	function setProduct(){
		var t = null;

		if ( typeof this !== "undefined" ) {
			t = $( this ).val();

			if ( t === product ) return;

			product = t;
			window.localStorage.setItem( 'cProduct', product );

		} else {
			product = null;
			window.localStorage.removeItem( 'cProduct' );
		}

		initSidebar();
	}


	function goToStep1( e ) {
		var o;

		e.preventDefault();
		e.stopImmediatePropagation();

		o = parseQuery();
		o.route = 'constructor/step1';
		redirect( makeQuery( o ) );

		return true;
	};

	function goToStep2( e ) {
		var o;

		e.preventDefault();
		e.stopImmediatePropagation();

		if ( category ) {
			o = parseQuery();
			o.route = 'constructor/step2';
			o.id = category;
			redirect( makeQuery( o ) );
		}

		return true;
	};

	function goToStep3( e ) {
		var o;

		e.preventDefault();
		e.stopImmediatePropagation();

		if ( category && subcategory ) {
			o = parseQuery();
			o.route = 'constructor/step3';
			o.id = category;
			o.sid = subcategory;
			redirect( makeQuery( o ) );
		}

		return true;
	};

	function goToStep4() {

	}

	function goToStep5() {

	}

	function redirect( search ) {
		// window.location.assign( window.location.protocol + "//" + window.location.host + window.location.pathname + makeQuery( o ) );
		window.location.search = search;
	}

	function parseQuery( q ) {
		var
			o = {},
			i = 0;

		if ( !q ) {
			q = window.location.search;

		} else {
			if ( ( i = q.indexOf( "?" ) ) > 0 ) {
				q = q.substr( ++i );
			}
		}

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
		$( ".constructor-edit-sidebar" ).show();
		initSidebar();
	}

	function filter() {
		var
			o = parseQuery( $( this ).val() );

		o.route = "constructor/step3/product";

		$( step3ProductName ).load( "/" + makeQuery( o ), function() {
			o.route = "constructor/step3/filter"
			$( step3FilterWrapperName ).load( "/" + makeQuery( o ) );
			if ( product )initProduct();
		} );
	}

	function initSidebar() {
		$( ".sidebar-number" ).show();
		$( ".sidebar-bullet" ).hide();

		$.each( [ null, category, subcategory, product ], function( i, v ) {
			if ( v ) {
				$( ".go-to-step" + i ).find( ".sidebar-number" ).hide().end().find( ".sidebar-bullet" ).show();
			}
		} );
	}
}

window.c = new C();