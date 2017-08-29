
/**
 * Initializes file browser for select attachment window
 * @returns {void}
 */
function elfinderAttachmentInit() {

	var
		$self = this,
		full_lng = null,
		i18nPath = adkLocale.elfinderI18n,
		lng = null,
		locm = null,
		loct = window.location.search,
		start = function start( lng ) {

			$().ready( function a() {
				var elf = $self.elfinder( {
					lang:     lng,
					url:      adkLocale.elfinderAttachmentAction.replace( /&amp;/, "&" ),
					commands: [
						"open",
						"reload",
						"home",
						"up",
						"back",
						"forward",
						"getfile",
						"quicklook",
						"download",
						"rm",
						"duplicate",
						"rename",
						"mkdir",
						"mkfile",
						"upload",
						"copy",
						"cut",
						"paste",
						"edit",
						"extract",
						"archive",
						"search",
						"info",
						"view",
						"resize",
						"sort",
						"chmod",
						"reload"
					],
					contextmenu: {
						navbar: [ "open", "|", "copy", "|", "cut", "paste", "duplicate", "|", "rm", "|", "info" ],
						cwd:    [ "reload", "back", "|", "upload", "mkdir", "mkfile", "paste", "|", "sort", "|", "info" ],
						files:  [ "getfile", "|", "custom", "quicklook", "|", "download", "|", "copy", "cut", "paste", "duplicate", "|", "rm", "|", "edit", "rename", "resize", "|", "archive", "extract", "|", "info", "chmod" ]
					},
					handlers: {
						dblclick: function dc(e) {
							console.log( elf.file(e.data.file));
							return false;
						}
					}
				} ).elfinder( "instance" );
			} );
		};

	// detect language
	if ( loct && ( locm = loct.match( /lang=([a-zA-Z_-]+)/ ) ) ) {
		full_lng = locm[ 1 ];
	} else {
		full_lng = navigator.browserLanguage || navigator.language || navigator.userLanguage;
	}

	lng = full_lng.substr( 0, 2 );

	if ( lng === "ja" ) {
		lng = "jp";
	} else if ( lng === "pt" ) {
		lng = "pt_BR";
	} else if ( lng === "zh" ) {
		lng = full_lng.substr( 0, 5 ) === "zh-tw" ? "zh_TW" : "zh_CN";
	}

	if ( lng === "en" ) {
		start( lng );
	} else {
		$.ajax( {
			url:      i18nPath + "/elfinder." + lng + ".js",
			cache:    true,
			dataType: "script"
		} )
		.done( function done() {
			start( lng );
		} )
		.fail( function fail() {
			start( "en" );
		} );
	}
}
