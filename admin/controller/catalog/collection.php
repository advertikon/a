<?php
class ControllerCatalogCollection extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/category');
		$this->load->model( 'extension/theme/arbole' );

		$this->document->setTitle( 'Collections' );

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/category');

		$this->document->setTitle( 'Add collection item' );

		$this->load->model('catalog/category');
		$a = \Advertikon\Arbole\Advertikon::instance();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = [];

			foreach( [ 'name', 'material', 'collection', 'price', 'weight', 'length', 'image', ] as $item ) {
				$data[ $item ] = $a->post( $item );
			}

			if( $a->add_collection( $data ) ) {
				$this->session->data['success'] = 'Item has been added';

				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				$this->response->redirect($this->url->link('catalog/collection', 'user_token=' . $this->session->data['user_token'] . $url, true));
			} else {
				$this->error['warning'] = 'Failed to save item';
			}
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/category');

		$this->document->setTitle( 'Edit collection item' );
		$a = \Advertikon\Arbole\Advertikon::instance();

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = [];

			foreach( [ 'name', 'material', 'collection', 'price', 'weight', 'length', 'image', 'id' ] as $item ) {
				$data[ $item ] = $a->post( $item );
			}

			if( $a->edit_collection( $data ) ) {
				$this->session->data['success'] = 'Item has been edited';

				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				$this->response->redirect($this->url->link('catalog/collection', 'user_token=' . $this->session->data['user_token'] . $url, true));
			} else {
				$this->error['warning'] = 'Failed to edit item';
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/category');

		$this->document->setTitle( 'Collections' );
		$a = \Advertikon\Arbole\Advertikon::instance();

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$a->delete_collection( $id );
			}

			$this->session->data['success'] = 'Item has been deleted';

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/collection', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		$next_order = 'ASC' === $order ? 'DESC' : 'ASC';

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$a = \Advertikon\Arbole\Advertikon::instance();

		$url = [];

		if (isset($this->request->get['sort'])) {
			$url['sort'] = $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url['order'] = $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url['page'] = $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Collections',
			'href' => $a->u('catalog/collection', $url ),
		);

		$data['add'] = $a->u( 'catalog/collection/add', $url );
		$data['delete'] = $a->u( 'catalog/collection/delete', $url );

		$data['collections'] = array();

		$filter_data = array(
			'order_by' => [ $sort => $order, ],
			'start'    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'    => $this->config->get('config_limit_admin')
		);

		$total = 0;
		$t_wrapper = [ 'total' => &$total ];
		$results = $this->model_extension_theme_arbole->get_collections($filter_data, $t_wrapper );

		foreach ($results as $result) {
			$data['collections'][] = array(
				'id'         => $result['id'],
				'name'       => $result['name'],
				'collection' => $result['collection'],
				'edit'       => $a->u( 'catalog/collection/edit', [ 'id' => $result['id'] ] ),
				'delete'     => $a->u( 'catalog/collection/delete' ),
				'image'      => $result['image'],
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		if ( 'name' === $sort ) {
			$data['sort_name'] = $a->u( 'catalog/collection', array_merge( $url, [ 'sort' => 'name', 'order' => $next_order ] ) );

		} else {
			$data['sort_name'] = $a->u( 'catalog/collection', array_merge( $url, [ 'sort' => 'name', ] ) );
		}

		if ( 'collection' === $sort ) {
			$data['sort_collection'] = $a->u( 'catalog/collection', array_merge( $url, [ 'sort' => 'collection', 'order' => $next_order ] ) );

		} else {
			$data['sort_collection'] = $a->u( 'catalog/collection', array_merge( $url, [ 'sort' => 'collection', ] ) );
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/collection', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total - $this->config->get('config_limit_admin'))) ? $total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total, ceil($total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/collection_list', $data));
	}

	protected function getForm() {
		$this->load->model( 'extension/theme/arbole' );
		$a = \Advertikon\Arbole\Advertikon::instance();

		$this->document->addScript( 'view/javascript/advertikon/select2/select2.full.min.js' );
		$this->document->addStyle( 'view/stylesheet/advertikon/select2/select2.min.css' );

		$data['text_form'] = !isset($this->request->get['category_id']) ? 'Add collection item' : 'Edit collection item';

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = [];

		if (isset($this->request->get['sort'])) {
			$url['sort'] = $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url['order'] = $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url['page'] = $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $a->u( 'common/dashboard' ),
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Collections',
			'href' => $a->u( 'catalog/collection' ),
		);

		if (!isset($this->request->get['id'])) {
			$data['action'] = $a->u( 'catalog/collection/add', $url );
		} else {
			$data['action'] = $a->u( 'catalog/collection/edit', array_merge( [ 'id=' => $this->request->get['id'] ], $url ) );
		}

		$data['cancel'] = $a->u( 'catalog/collection' );
		$collection = new \Advertikon\DB_Result( [] );

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$collection = $this->model_extension_theme_arbole->get_collection( $this->request->get['id'] );
			$data['id'] = $collection['id'];
		}

		$name = 'name';
		$data[ $name ] = $a->r()->render_form_group( [
			'label' => $a->__( 'Name' ),
			'element' => $a->r( [
				'type'   => 'text',
				'value'  => $a->post( $name, $collection[ $name ] ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
			'error'  => isset( $this->error[ $name ] ) ? $this->error[ $name ] : false,
		] );

		$name = 'collection';
		$data[ $name ] = $a->r()->render_form_group( [
			'label' => $a->__( 'Collection' ),
			'element' => $a->r( [
				'type'   => 'select',
				'active'  => $a->post( $name, $collection[ $name ] ),
				'class'  => 'form-control select2',
				'value'  => $this->model_extension_theme_arbole->get_collection_names(),
				'name'   => $name,
			] ),
			'error'  => isset( $this->error[ $name ] ) ? $this->error[ $name ] : false,
		] );

		$name = 'material';
		$data[ $name ] = $a->r()->render_form_group( [
			'label' => $a->__( 'Material' ),
			'element' => $a->r( [
				'type'   => 'select',
				'active'  => $a->post( $name, $collection[ $name ] ),
				'class'  => 'form-control',
				'value'  => $a->get_material(),
				'name'   => $name,
			] ),
			'error'  => isset( $this->error[ $name ] ) ? $this->error[ $name ] : false,
		] );

		$name = 'image';
		$data[ $name ] = $a->r()->render_form_group( [
			'label' => $a->__( 'Image' ),
			'element' => $a->r( [
				'type'   => 'image',
				'value'  => $a->post( $name, $collection[ $name ] ),
				'class'  => 'form-control select2',
				'name'   => $name,
			] ),
			'error'  => isset( $this->error[ $name ] ) ? $this->error[ $name ] : false,
		] );

		$name = 'price';
		$data[ $name ] = $a->r()->render_form_group( [
			'label' => $a->__( 'Price' ),
			'element' => $a->r( [
				'type'   => 'number',
				'value'  => $a->post( $name, $collection[ $name ] ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
			'error'  => isset( $this->error[ $name ] ) ? $this->error[ $name ] : false,
		] );

		$name = 'weight';
		$data[ $name ] = $a->r()->render_form_group( [
			'label' => $a->__( 'Weight' ),
			'element' => $a->r( [
				'type'   => 'number',
				'value'  => $a->post( $name, $collection[ $name ] ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
			'error'  => isset( $this->error[ $name ] ) ? $this->error[ $name ] : false,
		] );

		$name = 'length';
		$data[ $name ] = $a->r()->render_form_group( [
			'label' => $a->__( 'Length' ),
			'element' => $a->r( [
				'type'   => 'number',
				'value'  => $a->post( $name, $collection[ $name ] ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
			'error'  => isset( $this->error[ $name ] ) ? $this->error[ $name ] : false,
		] );

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/collection_form', $data));
	}

	protected function validateForm() {
		$a = \Advertikon\Arbole\Advertikon::instance();

		if (!$this->user->hasPermission('modify', 'catalog/collection')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ( !isset( $this->request->post[ $a->prefix_name( 'collection' ) ] ) ) {
			$this->error['collection'] = 'Field is mandatory';
		}

		if ( null === $a->post( 'material' ) ) {
			$this->error['material'] = 'Field is mandatory';

		} else {
			// $a->add_material( $a->post( 'material' ) );	
		}


		if ( null === $a->post( 'image' ) ) {
			$this->error['image'] = 'Field is mandatory';
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_category->getCategories($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
