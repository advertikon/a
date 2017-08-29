<?php
class ControllerCommonCurrency extends Controller {
	public function index() {
		$this->load->language('common/currency');

		$data['action'] = $this->url->link('common/currency/currency', '', $this->request->server['HTTPS']);

		$data['code'] = $this->session->data['currency'];

		$this->load->model('localisation/currency');

		$data['currencies'] = array();

		$results = $this->model_localisation_currency->getCurrencies();

		$data['current'] = [];

		foreach ($results as $result) {
			if ($result['status']) {
				$t = array(
					'title'        => $result['title'],
					'code'         => $result['code'],
					'symbol_left'  => $result['symbol_left'],
					'symbol_right' => $result['symbol_right'],
					'href'         => $this->url->link(
						'common/currency/currency',
						[ 'code' => $result['code'] ],
						$this->request->server['HTTPS']
					),
				);

				if ( $data['code'] === $result['code'] ) {
					$t['active'] = true;
					$data['current'] = $t;
				}

				$data['currencies'][] = $t;
			}
		}

		if (!isset($this->request->get['route'])) {
			$data['redirect'] = $this->url->link('common/home');
		} else {
			$url_data = $this->request->get;

			unset($url_data['_route_']);

			$route = $url_data['route'];

			unset($url_data['route']);

			$url = '';

			if ($url_data) {
				$url = '&' . urldecode(http_build_query($url_data, '', '&'));
			}

			$data['redirect'] = $this->url->link($route, $url, $this->request->server['HTTPS']);
		}

		return $this->load->view('common/currency', $data);
	}

	public function currency() {
		if (isset($this->request->request['code'])) {
			$this->session->data['currency'] = $this->request->request['code'];
		
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}
		
		if (isset($this->request->post['redirect'])) {
			$this->response->redirect($this->request->post['redirect']);
		} else {
			$this->response->redirect($this->url->link('common/home'));
		}
	}
}