<?php
class ControllerAccountDesigns extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/designs', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$image_width = $image_height = 220;

		$this->load->language('account/wishlist');

		$this->load->model('account/wishlist');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['remove'])) {
			// Remove Wishlist
			$this->model_account_wishlist->deleteWishlist($this->request->get['remove']);

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->response->redirect($this->url->link('account/wishlist'));
		}

		$this->document->setTitle( 'My designs' );

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['products'] = array();

		$a = \Advertikon\Arbole\Advertikon::instance();
		$results = $a->get_designs_by_customer( (int)$this->customer->getId() );
		$sizes = $a->get_sizes();

		foreach ($results as $result) {
			$product_info = $this->model_catalog_product->getProduct($result['product_id']);

			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $image_width, $image_height );
				} else {
					$image = false;
				}

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				$your_size = [];
				$option_your_size = ADK( 'Advertikon\\Arbole' )->config( 'your_size' );
				$product_options = $this->model_catalog_product->getProductOptions( $product_info['product_id'] );

				$size = [];

				foreach( $product_options as $option ) {
					if ( array_key_exists( $option['option_id'], $sizes ) ) {
						$size[] = array_merge( $option,  $sizes[ $option['option_id'] ] );
					}
				}

				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'stock'      => $stock,
					'price'      => $price,
					'special'    => $special,
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id']),
					'size'       => $size,
				);
			} else {
				//$this->model_account_wishlist->deleteWishlist($result['product_id']);
			}
		}

		$data['continue'] = $this->url->link('account/account', '', true);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/designs', $data));
	}

	public function remove() {
		$id = isset( $this->request->request['product_id'] ) ? (int)$this->request->request['product_id'] : 0;

		if ( $id > 0 ) {
			$this->db->query( "update " . DB_PREFIX . "arbole_customization set saved = 0 where product_id = " . $id . " and customer_id = " . (int)$this->customer->getId() );
		}
	}
}
