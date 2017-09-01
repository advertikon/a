<?php
class ControllerProductCategory extends Controller {
	public function index() {
		if ( !function_exists( 'ADK' ) ) {
			if ( !class_exists( 'Advertikon\Arbole\Advertikon' ) ) {
				Advertikon\Arbole\Advertikon::instance();
			}
		}

		if ( !function_exists( 'ADK' ) ) {
			function ADK() {
				return new Placeholder();
			}
		}

		$this->load->language('product/category');

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$image_width = 220;
		$image_height = 220;

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['path'])) {
			$url = '';

			$path = '';
			$parts = explode('_', (string)$this->request->get['path']);
			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}

		} else {
			$category_id = 0;
		}

		$category_info = $this->model_catalog_category->getCategory( $category_id );

		if ($category_info) {
			$this->document->setTitle($category_info['meta_title']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			$data['heading_title'] = $category_info['name'];

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'], 'SSL' )
			);


		} else {
			$this->document->setTitle( ADK()->__( 'Arbole|Catalog' ) );
			$data['heading_title'] = ADK()->__( 'Catalog' );

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => ADK()->__( 'Catalog' ),
				'href' => $this->url->link('product/category', null, 'SSL' )
			);
		}

		$pagination = new \Advertikon\Pagination( [
			'filter' => [
				'path' => [
					'name'    => 'p2c.category_id',
					'default' => false,
				],
				'language' => [
					'name'    => 'pd.language_id',
					'default' => (int)$this->config->get('config_language_id'),
				],
				'status' => [
					'name'    => 'p.status',
					'default' => '1',
				],
				'date' => [
					'name'     => 'p.date_available',
					'default'  => 'NOW()',
					'operator' => '<=',
				],
				'store' => [
					'name'    => 'p2s.store_id',
					'default' => (int)$this->config->get('config_store_id'),
				],
				'material' => [
					'name'    => 'pov.option_value_id',
					'default' => false,
				],
				'custom' => [
					'name'    => 'p.custom',
					'default' => 1,
				],
			],
			'sort' => [
				'price_low' => [
					'name'  => 'special, p.price ASC',
				],
				'price_high' => [
					'name'    => 'special, p.price DESC',
					'default' => true,
				],
			],
		] );

		$pagination->set_query(
			"SELECT
				p.*,
				pd.name,
				pd.description,
				(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating,
				(SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,
				(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special
			FROM " . DB_PREFIX . "product_to_category p2c
			LEFT JOIN " . DB_PREFIX . "product p
				ON (p2c.product_id = p.product_id)
			LEFT JOIN " . DB_PREFIX . "product_description pd
				ON (p.product_id = pd.product_id)
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s
				ON (p.product_id = p2s.product_id)
			LEFT JOIN " . DB_PREFIX . "product_option_value pov
				ON(p.product_id = pov.product_id)"
		);

		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

		$data['compare'] = $this->url->link('product/compare');

		$data['categories'] = [
			[ 'name' => 'All', 'href' => $pagination->url( 'path', null ) ],
		];

		$results = $this->model_catalog_category->get_top_level();

		foreach ($results as $result) {
			$data['categories'][] = array(
				'name'   => $result['name'],
				'href'   => $pagination->url( 'path', $result['category_id'] ),
				'active' => $result['category_id'] == $category_id,
			);
		}

		$data['material'] = [ [ 'name' => 'All', 'href' => $pagination->url( 'material', null ) ] ];

		foreach( $this->model_catalog_product->get_material() as $result ) {
			$data['material'][] = array(
				'name'   => $result['name'],
				'href'   => $pagination->url( 'material', $result['option_value_id'] ),
				'active' => $result['option_value_id'] == $pagination->get_filter_value( 'material' ),
			);
		}

		$data['sort'] = [
			[
				'name'   => ADK()->__( 'Price: low to high' ),
				'href'   => $pagination->url( 'sort', 'price_high' ),
				'active' => $pagination->is_sort( 'price_high' )
			],
			[
				'name'   => ADK()->__( 'Price: high to low' ),
				'href'   => $pagination->url( 'sort', 'price_low' ),
				'active' => $pagination->is_sort( 'price_low' )
			],
		];

		$data['custom_switch'] = ADK()->r( [
			'type'        => 'checkbox',
			'value'       => $pagination->url( 'custom', '1' ),
			'custom_data' => ( $pagination->get_filter_value( 'custom' ) ? 'checked="true"' : '' ) .
							' data-on="' . $pagination->url( 'custom', 1 )  . '"' .
							'data-off="' . $pagination->url( 'custom', 0 ) . '"',
			'id'          => 'show-designs',
			'label'       => ADK()->__( 'Users\' designs' ),
			'class'       => 'filter-page',
		] );

		$data['custom_switch1'] = ADK()->r( [
			'type'        => 'checkbox',
			'value'       => $pagination->url( 'custom', '1' ),
			'custom_data' => ( $pagination->get_filter_value( 'custom' ) ? 'checked="true"' : '' ) .
							' data-on="' . $pagination->url( 'custom', 1 )  . '"' .
							'data-off="' . $pagination->url( 'custom', 0 ) . '"',
			'id'          => 'show-designs1',
			'label'       => ADK()->__( 'Users\' designs' ),
			'name'        => 'custom',
		] );

		$data['products'] = array();

		$results = $pagination->run();;
		$product_total = $pagination->total;
		$page = $pagination->page;

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize( $result['image'], $image_width, $image_height );

			} else {
				$image = $this->model_tool_image->resize( 'placeholder.png', $image_width, $image_height );
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			$data['products'][] = array(
				'product_id'  => $result['product_id'],
				'thumb'       => $image,
				'name'        => $result['name'],
				'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
				'price'       => $price,
				'special'     => $special,
				'tax'         => $tax,
				'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
				'rating'      => $result['rating'],
				'href'        => $this->url->link('product/product', '&product_id=' . $result['product_id'] )
			);
		}

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/category', $data));

		// } else {
		// 	$url = '';

		// 	if (isset($this->request->get['path'])) {
		// 		$url .= '&path=' . $this->request->get['path'];
		// 	}

		// 	if (isset($this->request->get['filter'])) {
		// 		$url .= '&filter=' . $this->request->get['filter'];
		// 	}

		// 	if (isset($this->request->get['sort'])) {
		// 		$url .= '&sort=' . $this->request->get['sort'];
		// 	}

		// 	if (isset($this->request->get['order'])) {
		// 		$url .= '&order=' . $this->request->get['order'];
		// 	}

		// 	if (isset($this->request->get['page'])) {
		// 		$url .= '&page=' . $this->request->get['page'];
		// 	}

		// 	if (isset($this->request->get['limit'])) {
		// 		$url .= '&limit=' . $this->request->get['limit'];
		// 	}

		// 	$data['breadcrumbs'][] = array(
		// 		'text' => $this->language->get('text_error'),
		// 		'href' => $this->url->link('product/category', $url)
		// 	);

		// 	$this->document->setTitle($this->language->get('text_error'));

		// 	$data['continue'] = $this->url->link('common/home');

		// 	$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

		// 	$data['column_left'] = $this->load->controller('common/column_left');
		// 	$data['column_right'] = $this->load->controller('common/column_right');
		// 	$data['content_top'] = $this->load->controller('common/content_top');
		// 	$data['content_bottom'] = $this->load->controller('common/content_bottom');
		// 	$data['footer'] = $this->load->controller('common/footer');
		// 	$data['header'] = $this->load->controller('common/header');

		// 	$this->response->setOutput($this->load->view('error/not_found', $data));
		// }
	}
}
