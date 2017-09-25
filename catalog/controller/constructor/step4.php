<?php

class ControllerConstructorStep4 extends Controller {
	static $type_map = [

	];

	public function index() {
		$this->document->addScript( 'catalog/view/javascript/arbole/constructor.js' );
		$a = \Advertikon\Arbole\Advertikon::instance();

		$image_width = 300;
		$image_height = 470;

		if (isset($this->request->get['product'])) {
			$product_id = (int)$this->request->get['product'];
		} else {
			$product_id = 0;
		}

		if (isset($this->request->get['collection'])) {
			$collection = $this->request->get['collection'];

		} else {
			$collection = null;
		}

		$this->load->model('catalog/product');

		$product_info = $this->get_product_info( $product_id );

		if ($product_info) {
			$this->document->setTitle( 'Arbole' );

			$data['product_id'] = (int)$this->request->get['product'];
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['model'] = $product_info['model'];
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];
			$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			$data['name'] = $product_info['name'];

			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			$this->load->model('tool/image');

			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $image_width, $image_height );
			} else {
				$data['popup'] = '';
			}

			$data['images'] = array();

			$results = $this->model_catalog_product->getProductImages($this->request->get['product']);

			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $image_width, $image_height ),
				);
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['price'] = false;
			}

			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['special'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}

			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product']);

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
				);
			}

			$data['options'] = array();
			$sizes = ADK( 'Advertikon\\Arbole' )->get_sizes();

			foreach ($this->model_catalog_product->getProductOptions($this->request->get['product']) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
						} else {
							$price = false;
						}

						$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$data['options'][] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

			$size = [];

			foreach( $data['options'] as $option ) {
				if ( array_key_exists( $option['option_id'], $sizes ) ) {
					$size[] = array_merge( $option,  $sizes[ $option['option_id'] ] );
				}
			}

			$data['size'] = $size;

			if ($product_info['minimum']) {
				$data['minimum'] = $product_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}

			$data['review_status'] = $this->config->get('config_review_status');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}
		}

		$data['type'] = $a->get_product_type( $product_id );

		
		$data['collections'] = $this->get_collections();
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('constructor/header');

		$this->response->setOutput($this->load->view('constructor/step4', $data));

	}

	public function get_collections() {
		$product_id = isset( $this->request->request['product'] ) ? $this->request->request['product'] : 0;
		$collection = isset( $this->request->request['collection'] ) ? $this->request->request['collection'] : null;
		$a = \Advertikon\Arbole\Advertikon::instance();
		$product_info = $this->get_product_info( $product_id );

		$pagination = new \Advertikon\Pagination( [
			'filter' => [
				'collection' => [
					'name'    => 'collection',
					'default' => false,
				],
				'material' => [
					'name'    => 'material',
					'default' => $a->get_product_material( $product_id ),
				],
			],
			'sort' => [
				'price_low' => [
					'name'  => 'price ASC',
				],
				'price_high' => [
					'name'    => 'price DESC',
					'default' => true,
				],
				'name_low' => [
					'name'  => 'name ASC',
				],
				'name_high' => [
					'name'  => 'name DESC',
				],
			],
		] );

		$pagination->item_per_page = 1000;

		$product_attribute = (int)$a->config( 'material' );

		$pagination->set_query( "SELECT	* FROM " . DB_PREFIX . $a->collection );

		$results = $pagination->run();
		$data['collectionset'] = [];

		foreach( $results as $r ) {
			if ( !isset( $data['collectionset'][ $r['collection'] ] ) ) {
				$data['collectionset'][ $r['collection'] ] = [];
			}

			$data['collectionset'][ $r['collection'] ][ $r['id'] ] = [
				'name'            => $r['name'],
				'weight'          => $r['weight'],
				'length'          => $r['length'],
				'price'           => $r['price'],
				'image'           => $r['image'],
				'price_formatted' => $this->currency->format( $this->tax->calculate( $r['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']),
			];
		}

		$data['collections'] = [
			[ 'name' => 'All', 'href' => $pagination->url( 'collection', null, 'constructor/step4', [ 'product' => $product_id ] ) ],
		];

		$results = $a->get_collections();

		foreach ($results as $result) {
			$data['collections'][ $result['collection'] ] = array(
				'name'   => $result['collection'],
				'href'   => $pagination->url( 'collection', $result['collection'], 'constructor/step4/collection', [ 'product' => $product_id ] ),
				'active' => $result['collection'] == $collection,
			);
		}

		$data['sort'] = [
			[
				'name'   => ADK()->__( 'Price: high to low' ),
				'href'   => $pagination->url( 'sort', 'price_high', 'constructor/step4/collection', [ 'product' => $product_id ] ),
				'active' => $pagination->is_sort( 'price_high' )
			],
			[
				'name'   => ADK()->__( 'Price: low to high' ),
				'href'   => $pagination->url( 'sort', 'price_low', 'constructor/step4/collection', [ 'product' => $product_id ] ),
				'active' => $pagination->is_sort( 'price_low' )
			],
			[
				'name'   => ADK()->__( 'Name: A to Z' ),
				'href'   => $pagination->url( 'sort', 'name_low', 'constructor/step4/collection', [ 'product' => $product_id ] ),
				'active' => $pagination->is_sort( 'name_low' )
			],
			[
				'name'   => ADK()->__( 'Name: Z to A' ),
				'href'   => $pagination->url( 'sort', 'name_high', 'constructor/step4/collection', [ 'product' => $product_id ] ),
				'active' => $pagination->is_sort( 'name_high' )
			],
		];

		return  $this->load->view('constructor/collection_set', $data);
	}

	public function get_product_info( $id ) {
		if ( !$this->p_info ) {
			$this->load->model( 'catalog/product' );
			$this->p_info = $this->model_catalog_product->getProduct($id);
		}

		return $this->p_info;
	}

	public function collection() {
		$this->response->setOutput( $this->get_collections() );
	}
}