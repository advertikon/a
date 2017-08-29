<?php
/**
 * Advertikon Class
 * @author Advertikon
 * @package Arbole
 * @version 0.00.000
 */

namespace Advertikon\Arbole;

class Advertikon extends \Advertikon\Advertikon {

	// ******************** Common part **************************************//
	public $type = 'theme';
	public $code = 'arbole';
	public static $c = __NAMESPACE__;
	public $tables = array(

	);

	// ********************** Common part ************************************//

	static $instance = null;

	/**
	 * Returns class' singleton
	 * @return object
	 */
	public static function instance( $code = null ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			parent::$instance[ self::$c ] = self::$instance;
		}

		return self::$instance;
	}

	public static $file = __FILE__;

	public function __construct() {
		if ( version_compare( VERSION, '2.3.0.0', '>=' ) ) {
			$this->type = 'extension/' . $this->type;
		}

		parent::__construct();
		$this->compression_level = parent::COMPRESSION_LEVEL_NONE;
	}


	/**
	 * @see Advertikon\Advertikon::get_version()
	 */
	static public function get_version() {
		return parent::get_version();
	}

	/**
	 * Checks library compatibility
	 * @return array
	 */
	public function check_compatibility(){
		$all_is_bad = false;
		$name = 'arbole';
		$return = parent::check_compatibility();

		// CURL library presence
		// if ( $all_is_bad || ! function_exists( 'curl_version' ) ) {
		// 	$return[ $name ]['error'][] = $this->__( 'PHP CURL library missing' ) . '. ' .
		// 	sprintf(
		// 		'%s<a href="%s" target="_blank">%s</a>',
		// 		$this->__( 'Follow this link to ' ),
		// 		'http://php.net/manual/book.curl.php',
		// 		$this->__( 'get more details' )
		// 	);
		// }

		return $return;
	}

	public function get_prefix( $name = null ) {
		return 'theme_' . $this->code;
	}

	public function get_top_categories() {
		$ret = [];

		$q = $this->db->query( "SELECT cd.name, c.category_id as id, c.image, c.sort_order FROM " . DB_PREFIX . "category c JOIN " . DB_PREFIX . "category_description cd USING(category_id) WHERE c.status = 1 AND c.top = 1 AND cd.language_id = " . $this->config->get( 'config_language_id' ) . " ORDER by c.sort_order" );

		if ( $q && $q->rows ) {
			$ret = $q->rows;
		}

		return $ret;
	}
}
