<?php

class ControllerConstructorStep2 extends Controller {
	public function index() {
		$this->document->addScript( 'catalog/view/javascript/arbole/constructor.js' );
		$category_id = isset( $this->request->request['id'] ) ? $this->request->request['id'] : 0;

		$data['header'] = $this->load->controller('constructor/header');
		$data['subcategories'] = \Advertikon\Arbole\Advertikon::instance()->get_sub_categories( $category_id );

		$this->response->setOutput($this->load->view('constructor/step2', $data));
	}
}