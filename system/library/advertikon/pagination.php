<?php
/**
 * Advertikon Pagination Class
 * @author Advertikon
 * @package Advertikon
 * @version 00.000.0000 
 */

namespace Advertikon;

class Pagination extends \Model {
	public $total_page = 0;
	public $total = 0;
	public $page = null;
	public $item_per_page = 20;
	public $first_element = 0;
	public $last_element = 0;

	protected $query = null;
	protected $filter = array();
	protected $sort = array();
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
// echo $this->query . $this->get_filter() . $this->get_sort() . $this->get_limit();
			$this->data = $this->db->query( $this->query . $this->get_filter() . $this->get_sort() . $this->get_limit() );
			if ( $this->data ) {
				$total = $this->db->query( "SELECT FOUND_ROWS() as total" );

				if ( $total && $total->num_rows > 0 ) {
					$this->total = $total->row['total'];
					$this->total_page = ceil( $this->total / $this->item_per_page );

					if ( $this->total_page > 0 ) {
						$this->first_element = ( ( $this->page - 1 ) * $this->item_per_page ) + 1;
						$this->last_element = $this->total_page != $this->page ?
							$this->first_element + $this->item_per_page - 1 : $this->total % $this->item_per_page;
					}
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
		$this->init_filter();
		$this->q = new Query();
		$where = ' WHERE';
		$total_count = 0;

		foreach( $this->filter as $alias => $data ) {
			if ( is_array( current( $data ) ) ) {
				$count = 0;
				$d_count = count( $data );
				$parenth = false;

				foreach( $data as $w ) {
					if ( 0 === $count && $where ) {
						$where .= ' ' . $this->get_glue( $w );

						if ( $d_count > 1 ) {
							$where .= ' (';
							$parenth = true;
						}
					}

					$where .= $this->get_where( $where, $w, 0 === $count );

					if ( ++$count === $d_count && $parenth ) {
						$where .= ' )';
					}
				}

			} else {

				$where .= $this->get_where( $where, $data, 0 === $total_count );
			}

			$total_count++;
		}

		return $where;
	}

	protected function get_where( $where, $data, $first = false ) {
		$operator = $this->get_operator( $data );
		$glue = $this->get_glue( $data );

		if ( $first ) {
			return ' ' . $this->db->escape( $data['name'] ) . ' ' . $operator . ' ' . $this->get_value( $data );

		} else {
			return ' ' . $glue . ' ' . $this->db->escape( $data['name'] ) . ' ' . $operator . ' ' . $this->get_value( $data );
		}
	}

	protected function get_value( $data ) {
		if ( null === $this->q ) {
			$this->q = new Query();
		}

		$value = '';

		if ( isset( $data['value'] ) ) {
			$value = $data['value'];

			if ( isset( $data['wrap'] ) ) {
				$value  = $data['wrap'] . $value . $data['wrap'];
			}

			$value = $this->q->escape_db( $value );
		}

		return $value;
	}

	/**
	 * Initializes filters
	 * @return void
	 */
	protected function init_filter() {
		if ( $this->filter_init ) return;

		foreach( $this->filter as $alias => &$data ) {
			if ( is_array( current( $data ) ) ) {
				$count = 0;
				foreach( $data as &$d ) {
					if( false === $this->iff( $alias, $d ) ) {
						unset( $this->filter[ $alias ][ $count ] );
					}

					$count++;
				} 

			} else {
				if( false === $this->iff( $alias, $data ) ) {
					unset( $this->filter[ $alias ] );
				}
			}
		}

		unset( $data );
		$this->filter_init = true;
	}

	protected function iff( $alias, &$data ) {
		if ( isset( $this->request->get[ $alias ] ) ) {
			$data['value'] = $this->request->get[ $alias ];

		} elseif ( isset( $data['default'] ) && false !== $data['default'] ) {
			$data['value'] = $data['default'];

		} else {
			return false;
		}

		return true;
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
			if ( isset( $this->request->get['page'] ) ) {
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
		return isset( $o['operator'] ) && in_array( $o['operator'], [ '>', '<', '<=', '>=', '<>', 'LIKE', 'IN', ] ) ? $o['operator'] : '=';
	}

	/**
	 * Sanitizes glue
	 * @param string $g
	 * @return string
	 */
	protected function get_glue( $g ) {
		return isset( $g['glue'] ) && 'OR' === strtoupper( $g['glue'] ) ? 'OR' : 'AND';
	}

	/**
	 * Returns URL with query string, containing filtering and sorting parameters
	 * @param string|null $alias Parameter (alias) to be set/unset
	 * @param string|null $value Parameter value, if NULL alias will be unset
	 * @return type
	 */
	public function url( $alias = null, $value = null, $route = '', $q = array() ) {
		$this->init_filter();
		$this->init_sort();
		$query = [ 'page' => $this->page ];

		if ( is_array( $q ) ) {
			$query = array_merge( $query, $q );
		}

		foreach( $this->filter as $item_alias => $item ) {

			// Show only active filters without default ones
			if ( !isset( $this->request->get[ $item_alias ] ) ) continue;

			if ( is_array( current( $item ) ) ) {
				$item = current( $item );
			}

			$query[ $item_alias ] = $item['value'];
		}

		foreach( $this->sort as $item_alias => $item ) {
			if ( !isset( $this->request->get['sort'] ) || $this->request->get['sort'] !== $item_alias ) continue;
			$query['sort'] = $item_alias;
		}

		if ( !is_null( $alias ) ) {
			$value = (array)$value;

			foreach( (array)$alias as $i => $a ) {
				if ( isset( $value[ $i ] ) ) {
					$v = $value[ $i ];

				} else {
					$v = null;
				}

				if ( !is_null( $v ) ) {
					$query[ $a ] = $v;

				} else {
					unset( $query[ $a ] );
				}
			}
		}

		if ( !$route ) {
			$route = isset( $this->request->get['route'] ) ? $this->request->get['route'] : '';
		}

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