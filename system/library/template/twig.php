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
		}

		$image_func = new \Twig_SimpleFunction( 'image', function ( $str ) {
			
		    return ( defined( 'HTTPS_CATALOG' ) ? HTTPS_CATALOG : HTTPS_SERVER ) . 'image/' . $str;
		} );

		$this->twig->addFunction( $image_func );

		$filter_html_decode = new \Twig_SimpleFilter( 'html_decode', function ( $string ) {
			return htmlspecialchars_decode( $string );
		} );

		$this->twig->addFilter( $filter_html_decode );
		
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
