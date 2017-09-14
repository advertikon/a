<?php
class ControllerAccountLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/customer');

		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$this->load->language('account/login');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->try_to_login();

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
			'text' => $this->language->get('text_login'),
			'href' => $this->url->link('account/login', '', true)
		);

		$data['error_email'] = isset( $this->error['email'] ) ? $this->error['email'] : '';

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['action'] = $this->url->link('account/login', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['forgotten'] = $this->url->link('account/forgotten', '', true);

		// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
		if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
			$data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$data['redirect'] = $this->session->data['redirect'];

			unset($this->session->data['redirect']);
		} else {
			$data['redirect'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/login', $data));
	}

	protected function validate() {
		// Check how many login attempts have been made.
		// $login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

		// if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
		// 	$this->error['warning'] = $this->language->get('error_attempts');
		// }

		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info && !$customer_info['status']) {
			$this->error['email'] = $this->language->get('error_approved');
		}

		if (!$this->error) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$this->error['email'] = $this->language->get('error_login');

				// $this->model_account_customer->addLoginAttempt($this->request->post['email']);
			} else {
				// $this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
			}
		}

		return !$this->error;
	}

	protected function success() {
		// Unset guest
		unset($this->session->data['guest']);

		// Default Shipping Address
		$this->load->model('account/address');

		if ($this->config->get('config_tax_customer') == 'payment') {
			$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
		}

		if ($this->config->get('config_tax_customer') == 'shipping') {
			$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
		}

		// Wishlist
		if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
			$this->load->model('account/wishlist');

			foreach ($this->session->data['wishlist'] as $key => $product_id) {
				$this->model_account_wishlist->addWishlist($product_id);

				unset($this->session->data['wishlist'][$key]);
			}
		}

		if ( isset( $this->session->data['redirect'] ) ) {
			$r = $this->session->data['redirect'];
			unset( $this->session->data['redirect'] );
			$this->response->redirect( $r );

		} else {
			$this->response->redirect($this->url->link('account/account'), null, 'SSL' );
		}
	}

	protected function try_to_login() {
		Advertikon\Arbole\Advertikon::instance();

		if ( isset( $this->request->get['fb'] ) || isset( $this->request->get['google'] ) ) {
			require_once DIR_SYSTEM . 'library/Hybridauth/autoload.php';

			if ( isset( $this->request->get['google'] ) ) {
				$config = [
					'callback' => HTTPS_SERVER . 'index.php?route=account/login&google=1',
					'keys' => [ 
				       'id'     => ADK( 'Advertikon\\Arbole' )->config( 'social_g_id' ),
				       'secret' => ADK( 'Advertikon\\Arbole' )->config( 'social_g_secret' ),
				    ],
				    'scope'    => 'https://www.googleapis.com/auth/plus.login',
				];

			} else {
				$config = [
					'callback' => HTTPS_SERVER . 'index.php?route=account/login&google=1',
					'keys' => [ 
				        'id'     => ADK( 'Advertikon\\Arbole' )->config( 'social_fb_id' ),
				        'secret' => ADK( 'Advertikon\\Arbole' )->config( 'social_fb_secret' ),
				    ],
				    'scope'      => 'email',
				];
			}

			// $config['debug_mode'] = 'debug';
			// $config['debug_file'] = __DIR__ . '/hyb.log';

			try {
				if ( isset( $this->request->get['google'] ) ) {
					$adapter = new Hybridauth\Provider\Google($config);

				} else {
					$adapter = new Hybridauth\Provider\Facebook($config);
				}

				$adapter->authenticate();
				$userProfile = $adapter->getUserProfile();
				$tokens = $adapter->getAccessToken();

				if ( isset( $userProfile->email ) ) {
					if ( $this->customer->login( $userProfile->email, '', true ) ) {
						$this->success();

					} else {
						$this->error['email'] = 'Customer doesn\'t exist';
					}
				}

			} catch( Exception $e ){
				$this->log->write( 'Social login: ' . $e->getMessage() );
				$this->error['email'] = 'Authentication failed';
			}

		} else if ( isset( $this->request->get['guest'] ) ) {
			$this->session->data['guest'] = [];

			if ( isset( $this->session->data['redirect'] ) ) {
				$r = $this->session->data['redirect'];
				unset( $this->session->data['redirect'] );
				$this->response->redirect( $r );

			} else {
				$this->response->redirect( HTTPS_SERVER );
			}

		}  else if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->success();
		}
	}
}
