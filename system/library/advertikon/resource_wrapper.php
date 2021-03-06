<?php
/**
 * Advertikon Resource_Wrapper
 * @author Advertikon
 * @package Advertikon
 * @version 2.6.4   
 */

namespace Advertikon;

class Resource_Wrapper extends Array_Iterator {

	protected $class = '';

	public function __construct( $class, $key = null ) {
		$this->class = $class;
	}

	/**
	 * @see Array_Iterator::getOffset()
	 */
	public function offsetGet( $index ) {
		$o = parent::getOffset( $index );

		if ( ! is_object( $o ) ) {
			$o = new $this->class( $o );
			$this->offsetSet( $index, $o );
		}

		return $o;
	}

	/**
	 * @see Arrat_Iterator::current()
	 */
	public function current() {
		$o = parent::current();

		if ( ! is_object( $o ) ) {
			$o = new $this->class( $o );
			$this->offsetSet( $this->key(), $o );
		}

		return $o;
	}
}
