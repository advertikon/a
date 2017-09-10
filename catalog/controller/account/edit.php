<?php
class ControllerAccountEdit extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/edit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		$this->load->model('account/customer');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_edit'),
			'href' => $this->url->link('account/edit', '', true)
		);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['custom_field'])) {
			$data['error_custom_field'] = $this->error['custom_field'];
		} else {
			$data['error_custom_field'] = array();
		}

		if (isset($this->error['birth_day'])) {
			$data['error_birth_day'] = $this->error['birth_day'];
		} else {
			$data['error_birth_day'] = '';
		}

		if (isset($this->error['birth_month'])) {
			$data['error_birth_month'] = $this->error['birth_month'];
		} else {
			$data['error_birth_month'] = '';
		}

		if (isset($this->error['birth_year'])) {
			$data['error_birth_year'] = $this->error['birth_year'];
		} else {
			$data['error_birth_year'] = '';
		}

		$data['action'] = $this->url->link('account/edit', '', true);

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}

		if ( isset( $this->request->post['is_male'] ) ) {
			$data['is_male'] = (bool)$this->request->post['is_male'];

		} else {
			$data['is_male'] = empty( $customer_info['is_male'] ) ? false : true;
		}

		$data['birth_day'] = '';
		$data['birth_month'] = '';
		$data['birth_year'] = '';

		if ( isset( $customer_info['birth'] ) ) {
			if( false !== ( $d = date_parse( $customer_info['birth'] ) ) ) {
				$data['birth_day'] = $d['day'];
				$data['birth_month'] = $d['month'];
				$data['birth_year'] = $d['year'];
			}
		}

		if ( isset( $this->request->post['birth_day'] ) ) {
			$data['birth_day'] = $this->request->post['birth_day'];
		}

		if ( isset( $this->request->post['birth_month'] ) ) {
			$data['birth_minth'] = $this->request->post['birth_month'];
		}

		if ( isset( $this->request->post['birth_year'] ) ) {
			$data['birth_year'] = $this->request->post['birth_year'];
		}

		if ( $data['birth_day'] && $data['birth_month'] && $data['birth_year'] ) {
			$data['birth'] = strftime( '%d/%m/%Y' ,mktime( 0, 0, 0, $data['birth_day'], $data['birth_month'], $data['birth_year'] ) );
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($customer_info)) {
			$data['firstname'] = $customer_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($customer_info)) {
			$data['lastname'] = $customer_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($customer_info)) {
			$data['email'] = $customer_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($customer_info)) {
			$data['telephone'] = $customer_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		// Custom Fields
		$data['custom_fields'] = array();
		
		$this->load->model('account/custom_field');

		$custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		foreach ($custom_fields as $custom_field) {
			if ($custom_field['location'] == 'account') {
				$data['custom_fields'][] = $custom_field;
			}
		}

		if (isset($this->request->post['custom_field']['account'])) {
			$data['account_custom_field'] = $this->request->post['custom_field']['account'];
		} elseif (isset($customer_info)) {
			$data['account_custom_field'] = json_decode($customer_info['custom_field'], true);
		} else {
			$data['account_custom_field'] = array();
		}

		$data['back'] = $this->url->link('account/account', '', true);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/edit', $data));
	}

	protected function validate() {
		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}

		// if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
		// 	$this->error['telephone'] = $this->language->get('error_telephone');
		// }


		if ( empty( $this->request->post['birth_day'] ) || $this->request->post['birth_day'] < 1 || $this->request->post['birth_day'] > 31 ) {
			$this->error['birth_day'] = 'Invalid value';
		}

		if ( empty( $this->request->post['birth_month'] ) || $this->request->post['birth_month'] < 1 || $this->request->post['birth_month'] > 12 ) {
			$this->error['birth_month'] = 'Invalid value';
		}

		if ( empty( $this->request->post['birth_year'] ) || $this->request->post['birth_year'] < 1900 || $this->request->post['birth_year'] > date( 'Y' ) ) {
			$this->error['birth_year'] = 'Invalid value';
		}

		// Custom field validation
		$this->load->model('account/custom_field');

		$custom_fields = $this->model_account_custom_field->getCustomFields('account', $this->config->get('config_customer_group_id'));

		foreach ($custom_fields as $custom_field) {
			if ($custom_field['location'] == 'account') {
				if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
					$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
				} elseif (($custom_field['type'] == 'text') && !empty($custom_field['validation']) && !filter_var($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $custom_field['validation'])))) {
					$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
				}
			}
		}

		return !$this->error;
	}

	public function save() {
		if ( !$this->customer->isLogged() ) {
			$this->response->setOutput( json_encode( [ 'error' => 'You need to login' ] ) );
		}

		$this->load->language('account/edit');
		
		if ( !$this->validate() ) {
			$this->response->setOutput( json_encode( [ 'error' => $this->error ] ) );

		} else {
			$this->load->model( 'account/customer' );
			$this->request->post['telephone'] = '';
			$this->request->post['birth'] = strftime( '%Y-%m-%d' ,mktime( 0, 0, 0, $this->request->post['birth_day'], $this->request->post['birth_month'], $this->request->post['birth_year'] ) );
			$this->model_account_customer->editCustomer($this->customer->getId(), $this->request->post);

			if ( isset( $this->request->post['password'] ) ) {
				$this->model_account_customer->editPassword( $this->request->post['email'], $this->request->post['password'] );
			}

			$this->response->setOutput( json_encode( [ 'success' => true ] ) );
		}
	}
}