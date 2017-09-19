<?php

class ControllerConstructorStep1 extends Controller {
	public function index() {
		$this->document->addScript( 'catalog/view/javascript/arbole/constructor.js' );

		$data['header'] = $this->load->controller('constructor/header');
		$data['categories'] = \Advertikon\Arbole\Advertikon::instance()->get_top_categories();

		$this->response->setOutput($this->load->view('constructor/step1', $data));
	}
}