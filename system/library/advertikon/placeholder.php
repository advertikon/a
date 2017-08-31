<?php
/**
 * Advertikon Registry Placeholder class
 * @author Advertikon
 * @package Advertikon
 * @version 00.000.0000  
 */

namespace Advertikon;

class Placeholder extends \ArrayIterator {
	public function __get( $v ) {
		return new $this;
	}

	public function __call( $n, $v  ) {
		return $this;
	}

	public function __toString() {
		return '';
	}
}