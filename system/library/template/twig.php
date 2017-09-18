<?php
namespace Template;
final class Twig {
	private $twig;
	private $data = array();
	
	public function __construct() {
		// include and register Twig auto-loader
		include_once(DIR_SYSTEM . 'library/template/Twig/Autoloader.php');
		
		\Twig_Autoloader::register();
	}
	
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
	public function render($template, $cache = false) {
		// specify where to look for templates
		$loader = new \Twig_Loader_Filesystem(DIR_TEMPLATE);

		// initialize Twig environment
		$config = array('autoescape' => false);

		if ($cache) {
			$config['cache'] = DIR_CACHE;
			$config['auto_reload'] = true;
		}

		$this->twig = new \Twig_Environment($loader, $config);

		if ( class_exists( '\Advertikon\Arbole\Advertikon' ) ) {
			$translate_func = new \Twig_SimpleFunction( '__', function ( $str ) {
			    return \Advertikon\Arbole\Advertikon::instance()->__( $str );
			} );

			$this->twig->addFunction( $translate_func );

			$config_func = new \Twig_SimpleFunction( 'c', function ( $str, $def = '' ) {
			    return \Advertikon\Arbole\Advertikon::instance()->config( $str, $def );
			} );

			$this->twig->addFunction( $config_func );

			$url_func = new \Twig_SimpleFunction( 'u', function ( $route, $query = [] ) {
			    return \Advertikon\Arbole\Advertikon::instance()->u( $route, $query );
			} );

			$this->twig->addFunction( $url_func );

			$configuration_func = new \Twig_SimpleFunction( 'config', function ( $str ) {
			    return \Advertikon\Arbole\Advertikon::instance()->config->get( $str );
			} );

			$this->twig->addFunction( $configuration_func );

			$is_active_func = new \Twig_SimpleFunction( 'is_active', function ( $str ) {
				$ret = false;

			    if ( empty( $str ) || empty( $_GET['route'] ) ) return false;

			    if ( ( $p = strpos( $str, 'route=' ) ) !== false ) {
			    	$ret = strpos( urldecode( $_GET['route'] ), substr( $str, $p + 6 ) ) === 0;

			    } else {
					$ret =  strpos( urldecode( $_GET['route'] ), $str ) === 0;
			    	
			    }

			    return $ret;

			} );

			$this->twig->addFunction( $is_active_func );
		}

		$image_func = new \Twig_SimpleFunction( 'image', function ( $str ) {
		    return ( defined( 'HTTPS_CATALOG' ) ? HTTPS_CATALOG : HTTPS_SERVER ) . 'image/' . $str;
		} );

		$this->twig->addFunction( $image_func );

		$filter_html_decode = new \Twig_SimpleFilter( 'html_decode', function ( $string ) {
			return htmlspecialchars_decode( $string );
		} );

		$this->twig->addFilter( $filter_html_decode );

		$filter_wrap_p = new \Twig_SimpleFilter( 'wrap_p', function ( $string ) {
			$parts = preg_split( '/\r?\n/', $string );
			return '<p>' . implode( '</p><p>', $parts ) . '</p>';
		} );

		$this->twig->addFilter( $filter_wrap_p );
		
		try {
			// load template
			$template = $this->twig->loadTemplate($template . '.twig');
			
			return $template->render($this->data);
		} catch (Exception $e) {
			trigger_error('Error: Could not load template ' . $template . '!');
			exit();	
		}	
	}	
}
