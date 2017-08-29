<?php

namespace Advertikon;

class Pagination extends Model {
	protected $query = null;
	protected $filter = array();
	protected $sort = array();
	public $total = 0;
	public $page = null;
	public $item_per_page = 20;

	public function set_filter( $filter ) {
		if ( is_array( $filter ) ) {
			$this->filter = $filter;
		}
	}

	public function set_sort( $sort ) {
		if ( is_array( $sort ) ) {
			$this->sort = $sort;
		}
	}

	public function set_query( $query ) {
		if ( is_string( $query ) ) {
			$this->query = preg_replace( '/^select /i', 'SELECT SQL_CALC_FOUND_ROWS ', $select );
		}

		if ( strcmp( $this->query, $query ) === 0 ) {
			throw new \Exception( 'Error' );
		}
	}

	public function get() {
		if ( $this->query ) {
			$this->data = $this->db->query( $this->query . $this->get_filter() . $this->get_sort_order() . $this->get_limit() );

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


	protected function get_filter() {
		$f = array();

		foreach( $this->filter as $alias => $name ) {
			if ( isset( $this->request->get[ $alias ] ) ) {
				$f[] = $this->db->escape( $name ) . '=' . $this->db->escape( $this->request->get[ $alias ] );
			}
		}

		if ( $f ) {
			return ' WHERE ' . implode( ' AND ', $f );
		}

		return '';
	}

	protected function get_sort_order() {
		$f = array();

		foreach( $sort as $alias => $name ) {
			if ( isset( $this->request->get[ $alias ] ) ) {
				$f[] = $name;
			}
		}

		if ( $f ) {
			return 'ORDER BY ' . implode( ', ', $f );
		}

		return '';
	}

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


}