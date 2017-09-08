<?php

class ControllerCheckoutPay extends Controller {

	public function index() {
		$this->load->language('extension/shipping/free');

		$this->session->data['shipping_method'] = array(
			'code'         => 'free.free',
			'title'        => $this->language->get('text_description'),
			'cost'         => 0.00,
			'tax_class_id' => 0,
			'text'         => $this->currency->format(0.00, $this->session->data['currency'])
		);

		$this->load->language('extension/payment/pp_standard');

		$this->session->data['payment_method'] = array(
			'code'       => 'pp_standard',
			'title'      => $this->language->get('text_title'),
			'terms'      => '',
			'sort_order' => $this->config->get('payment_pp_standard_sort_order')
		);

		$this->session->data['comment'] = '';
		
		if ( false === $this->load->controller( 'checkout/confirm' ) ) {
			$this->response->setOutput( '<script>location.assign("' .  HTTP_SERVER . '")</script>' );

		} else {
			$this->response->setOutput( $this->load->controller( 'extension/payment/pp_standard' ) );
		}

	}

}