<?php

class ControllerConstructorStep1 extends Controller {
	public function index() {
		$data['header'] = $this->load->controller('common/header_constructor');
		$data['categories'] = \Advertikon\Arbole\Advertikon::instance()->get_top_categories();

		$this->response->setOutput($this->load->view('constructor/step1', $data));
	}
}