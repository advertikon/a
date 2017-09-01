<?php
/**
 * Advertikon Pagination Class
 * @author Advertikon
 * @package Advertikon
 * @version 00.000.0000 
 */

namespace Advertikon;

class Pagination extends \Model {
	protected $query = null;
	protected $filter = array();
	protected $sort = array();
	public $total = 0;
	public $page = null;
	public $item_per_page = 20;
	protected $data = [];
	protected $filter_init = false;
	protected $sort_init = false;

	/**
	 * Class constructor
	 * @param array $data Initializing data:
	 *   'filter':
	 *             key (filter alias to appear in query, eg 'model'): 
	 *                - 'name'     - DB filter entry, eg 'p.model'
	 *                - 'default'  - default value
	 *                - 'operator' - DB compare operator, eg '>='
	 * 	 'sort':
	 *           key (sort alias to be appear in query, eg 'price_high'):
	 *                - 'name' - DB filter entry, eg special, p.price DESC
	 *                       - 
	 * @return void
	 */
	public function __construct( $data = [] ) {
		global $adk_registry;

		if ( ! is_null( $adk_registry ) ) {
			parent::__construct( $adk_registry );

		} else {
			parent::__construct( new Placeholder() );
		}

		if ( isset( $data['filter'] ) ) {
			$this->set_filter( $data['filter'] );
		}

		if ( isset( $data['sort'] ) ) {
			$this->set_sort( $data['sort'] );
		}
	}

	/**
	 * Sets filters
	 * @param array $filter 
	 * @return void
	 */
	public function set_filter( $filter ) {
		if ( is_array( $filter ) ) {
			$this->filter = $filter;
		}
	}

	/**
	 * Adds filter to existing set
	 * @param array $filter 
	 * @return void
	 */
	public function add_filter( $filter ) {
		if ( is_array( $filter ) ) {
			$this->filter = array_merge( $this->filter, $filter );
		}
	}

	/**
	 * Sets sort rules
	 * @param array $sort 
	 * @return void
	 */
	public function set_sort( $sort ) {
		if ( is_array( $sort ) ) {
			$this->sort = $sort;
		}
	}

	/**
	 * Sets query (without WHERE and ORDER BY clauses)
	 * @param string $query 
	 * @return void
	 */
	public function set_query( $query ) {
		if ( is_string( $query ) ) {
			$count = 0;
			$this->query = preg_replace( '/^select(.*)/i', 'SELECT SQL_CALC_FOUND_ROWS$1', $query, 1, $count );

			if ( TEST && $count !== 1 ) {
				throw new \Exception( 'Failed to modify query to apply SQL_CALC_FOUND_ROWS functionality' );
			}
		}
	}

	/**
	 * Runs query
	 * @return array Query result
	 */
	public function run() {
		if ( $this->query ) {
			$this->data = $this->db->query( $this->query . $this->get_filter() . $this->get_sort() . $this->get_limit() );
			if ( $this->data ) {
				$total = $this->db->query( "SELECT FOUND_ROWS() as total" );

				if ( $total && $total->num_rows > 0 ) {
					$this->total = $total->row['total'];
				}

				return $this->data->rows;
			}
		}

		return array();
	}

	/**
	 * Creates WHERE clause for query
	 * @return string
	 */
	protected function get_filter() {
		$f = array();
		$this->init_filter();

		foreach( $this->filter as $alias => $data ) {
			$operator = '=';

			if ( isset( $data['operator'] ) ) {
				$operator = $this->get_operator( $data['operator'] );
			}

			$f[] = $this->db->escape( $data['name'] ) . $operator . $this->db->escape( $data['value'] );
		}

		if ( $f ) {
			return ' WHERE ' . implode( ' AND ', $f );
		}

		return '';
	}

	/**
	 * Initializes filters
	 * @return void
	 */
	protected function init_filter() {
		if ( $this->filter_init ) return;

		foreach( $this->filter as $alias => &$data ) {
			if ( isset( $this->request->get[ $alias ] ) ) {
				$data['value'] = $this->request->get[ $alias ];

			} elseif ( isset( $data['default'] ) && false !== $data['default'] ) {
				$data['value'] = $data['default'];

			} else {
				unset( $this->filter[ $alias ] );
			}
		}

		unset( $data );

		$this->filter_init = true;
	}

	/**
	 * Initializes sort parameters
	 * @return void
	 */
	protected function init_sort() {
		if ( $this->sort_init ) return;
		$default = [];

		foreach( $this->sort as $alias => $data ) {
			if ( isset( $data['default'] ) ) {
				$default[ $alias ] = $data['name'];
			}

			if ( isset( $this->request->get['sort'] ) && $this->request->get['sort'] === $alias ) { 
				$this->sort[ $alias ] = $data['name'];

			} else {
				unset( $this->sort[ $alias ] );
			}
		}

		if ( !$this->sort ) {
			$this->sort = $default;
		}

		$this->sort_init = true;
	}

	/**
	 * Returns ORDER BY clause of query
	 * @return string
	 */
	protected function get_sort() {
		$f = array();
		$this->init_sort();

		foreach( $this->sort as $alias => $name ) {
			$f[] = $name;
		}

		if ( $f ) {
			return ' ORDER BY ' . implode( ', ', $f );
		}

		return '';
	}

	/**
	 * Returns LIMIT clause for query
	 * @return string
	 */
	protected function get_limit() {
		if ( is_null( $this->page ) ) {
			if ( isset( $this->reguest->get['page'] ) ) {
				$this->page = (int)$this->request->get['page'];

			} else {
				$this->page = 1;
			}
		}

		if ( (int)$this->page < 1 ) {
			$page = 1;
		}

		return ' LIMIT ' . ( ( $this->page - 1 ) * $this->item_per_page ) . ', ' . $this->item_per_page;
	}

	/**
	 * Sanitizes comparison operators
	 * @param string $o 
	 * @return string
	 */
	protected function get_operator( $o ) {
		if ( in_array( $o, [ '>', '<', '<=', '>=', '<>', 'LIKE', 'IN', ] ) ) return $o;

		return '=';
	}

	/**
	 * Returns URL with query string, containing filtering and sorting parameters
	 * @param string|null $alias Parameter (alias) to be set/unset
	 * @param string|null $value Parameter value, if NULL alias will be unset
	 * @return type
	 */
	public function url( $alias = null, $value = null ) {
		$this->init_filter();
		$this->init_sort();
		$query = [ 'page' => $this->page ];

		foreach( $this->filter as $item_alias => $item ) {

			// Show only active filters without default ones
			if ( !isset( $this->request->get[ $item_alias ] ) ) continue;

			$query[ $item_alias ] = $item['value'];
		}

		foreach( $this->sort as $item_alias => $item ) {
			if ( !isset( $this->request->get['sort'] ) || $this->request->get['sort'] !== $item_alias ) continue;
			$query['sort'] = $item_alias;
		}

		if ( !is_null( $alias ) ) {
			if ( !is_null( $value ) ) {
				$query[ $alias ] = $value;

			} else {
				unset( $query[ $alias ] );
			}
		}

		$route = isset( $this->request->get['route'] ) ? $this->request->get['route'] : '';

		return preg_replace( '/&amp;/', '&', $this->url->link( $route, $query, 'SSL' ) );
	}

	/**
	 * Returns filter value in case filer is active (applied)
	 * @param string $alias 
	 * @return string
	 */
	public function get_filter_value( $alias ) {
		$ret = '';
		$this->init_filter();

		if ( isset( $this->filter[ $alias ], $this->filter[ $alias ]['value'] ) ) {
			$ret = $this->filter[ $alias ]['value'];
		}

		return $ret;
	}

	/**
	 * Determines if sort option is active (applied)
	 * @param string $alias 
	 * @return boolean
	 */
	public function is_sort( $alias ) {
		$ret = false;
		$this->init_sort();

		if ( isset( $this->sort[ $alias ] ) ) {
			$ret = true;
		}

		return $ret;
	}
}