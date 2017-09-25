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
		'collection'    => 'arbole_collection',
		'customization' => 'arbole_customization', 
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

	public function get_product_type( $id ) {
		$ret = '';

		$q = $this->db->query( "SELECT cd.name as 'name' FROM " . DB_PREFIX . "product_to_category p2c JOIN " . DB_PREFIX . "category c USING(category_id) JOIN " . DB_PREFIX . "category_description cd USING(category_id) WHERE c.status = 1 AND c.top = 1 AND cd.language_id = " . $this->config->get( 'config_language_id' ) . " AND p2c.product_id = " . (int)$id . " ORDER by c.sort_order" );

		if ( $q && $q->rows ) {
			$ret = $q->row['name'];

			if ( 's' === $ret[ strlen( $ret ) - 1 ] ) {
				$ret = substr( $ret, 0, -1 );
			}
		}

		return $ret;
	}

	public function get_top_categories() {
		$ret = [];

		$q = $this->db->query( "SELECT cd.name, c.category_id as id, c.image, c.render, c.sort_order FROM " . DB_PREFIX . "category c JOIN " . DB_PREFIX . "category_description cd USING(category_id) WHERE c.status = 1 AND c.top = 1 AND cd.language_id = " . $this->config->get( 'config_language_id' ) . " ORDER by c.sort_order" );

		if ( $q && $q->rows ) {
			$ret = $q->rows;
		}

		return $ret;
	}

	public function get_sub_categories( $parent_id ) {
		$ret = [];

		$q = $this->db->query( "SELECT cd.name, c.category_id as id, c.image, c.render, c.sort_order FROM " . DB_PREFIX . "category c JOIN " . DB_PREFIX . "category_description cd USING(category_id) WHERE c.status = 1 AND c.parent_id = " . (int)$parent_id . " AND cd.language_id = " . $this->config->get( 'config_language_id' ) . " ORDER by c.sort_order" );

		if ( $q && $q->rows ) {
			$ret = $q->rows;
		}

		return $ret;
	}

	public function get_your_size_option() {
		$options = [];

		foreach( $thiis->q( [
			'table'     => 'option',
			'operation' => 'select',
		] ) as $o ) {
			if ( $o['option_id'] == $this->cofnfig( 'your_size' ) ) {
				$options = $o;
			}
		}

		return $options;
	}

	public function get_sizes() {
		$ret = [];

		foreach( (array)$this->config( 'size') as $s ) {
			$ret[ $s['id'] ] = $s;
		}

		return $ret;
	}

	public function get_material() {
		$option_id = 0;
		$ret = [];

		$option_id = $this->config( 'material' );

		$q = $this->db->query( "SELECT DISTINCT text FROM " . DB_PREFIX . "product_attribute WHERE language_id = " . (int)$this->config->get( 'config_language_id' ) . " AND attribute_id = '" . (int)$option_id . "'" );

		if ( $q ) {
			foreach( $q->rows as $material ) {
				$ret[ $material['text'] ] = $material['text'];
			}
		}

		return $ret;
	}

	public function get_product_material( $id ) {
		$option_id = 0;
		$ret = '';

		$option_id = $this->config( 'material' );

		$q = $this->db->query( "SELECT text FROM " . DB_PREFIX . "product_attribute WHERE language_id = " . (int)$this->config->get( 'config_language_id' ) . " AND attribute_id = '" . (int)$option_id . "' AND product_id = " . (int)$id );

		if ( $q->num_rows ) {
			$ret = $q->row['text'];
		}

		return $ret;
	}

	public function get_collections() {
		$q = $this->q( [
			'table'    => $this->collection,
			'query'    => 'select',
			'value'    => 'collection',
		] );

		return $q;
	}

	public function add_collection( $data ) {
		$q = $this->q( [
			'table' => $this->collection,
			'query' => 'insert',
			'values' => [
				'name'       => $data['name'],
				'collection' => $data['collection'],
				'material'   => $data['material'],
				'image'      => $data['image'],
				'price'      => $data['price'],
				'weight'     => $data['price'],
				'length'     => $data['length'],
			],
		] );

		return $q;
	}

	public function edit_collection( $data ) {
		$q = $this->q( [
			'table' => $this->collection,
			'query' => 'update',
			'set'   => [
				'name'       => $data['name'],
				'collection' => $data['collection'],
				'material'   => $data['material'],
				'image'      => $data['image'],
				'price'      => $data['price'],
				'weight'     => $data['price'],
				'length'     => $data['length'],
			],
			'where' => [
				'field'     => 'id',
				'operation' => '=',
				'value'     => $data['id'],
			],
		] );

		return $q;
	}

	public function add_material( $material ) {
		$ret = $material;
		$create = true;
		$material_id = $this->config( 'material' );

		$q = $this->q( [
			'table' => 'product_attribute',
			'query' => 'select',
			'where' => [
				[
					'field'     => 'attribute_id',
					'operation' => '=',
					'value'     => $material_id,

				],
				[
					'field'     => 'text',
					'operation' => '=',
					'value'     => $material,
				]
			],
		] );

		if ( $q && count( $q ) ) {
			$create = false;
		} 

		if ( $create ) {
			$q = $this->q( [
				'table' => 'product_attribute',
				'query' => 'insert',
				'values' => [
					'product_id'   => 0,
					'attribute_id' => (int)$material_id,
					'language_id'  => $this->config->get( 'config_language_id' ),
					'text'         => $material,
				],
			] );

		}

		return $ret;
	}

	public function delete_collection( $id ) {
		$q = $this->q( [
			'table' => $this->collection,
			'query' => 'delete',
			'where' => [
				'field'     => 'id',
				'operation' => '=',
				'value'     => $id,
			],
		] );

		return $q;
	}
}
