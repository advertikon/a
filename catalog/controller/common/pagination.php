<?php
class ControllerCommonPagination extends Controller {
	public function index( $pagination ) {
		return $this->load->view( 'common/pagination', [ 'pagination' => array_shift( $pagination ), ] );
	}
}