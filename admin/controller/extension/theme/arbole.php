<?php
class ControllerExtensionThemeArbole extends Controller {
	private $error = array();

	public function __construct( $registry ) {
		parent::__construct( $registry );
		$this->a = \Advertikon\Arbole\Advertikon::instance();
		$this->load->model( $this->a->full_name );
		$this->model = $this->{'model_' . str_replace( '/', '_', $this->a->full_name )};
	}

	public function index() {

		$this->model->fix_tables();
	
		$this->load->language('extension/theme/' . $this->my_name );

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model( 'catalog/option' );
		$this->load->model( 'catalog/attribute' );

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting( $this->my_code, $this->request->post, $this->request->get['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect( $this->a->u()->url() );
		}

		$this->document->addScript( 'view/javascript/advertikon/advertikon.js' );
		// $this->document->addScript( 'view/javascript/constructor/fabric.min.js' );
		// $this->document->addScript( 'view/javascript/constructor/utils.js' );
		// $this->document->addScript( 'view/javascript/constructor/controls.js' );
		// $this->document->addScript( 'view/javascript/constructor/app.js' );
		// $this->document->addScript( 'view/javascript/select2/select2.min.js' );

		$this->document->addStyle( 'view/stylesheet/advertikon/advertikon.css' );
		// $this->document->addStyle( 'view/javascript/jquery/jquery-ui/jquery-ui.min.css' );
		// $this->document->addStyle( 'view/javascript/jquery/jquery-ui/jquery-ui.theme.min.css' );
		// $this->document->addStyle( 'view/javascript/jquery/jquery-ui/jquery-ui.structure.min.css' );
		// $this->document->addStyle( 'view/stylesheet/constructor/bootstrap-theme.css' );
		// $this->document->addStyle( 'view/stylesheet/constructor/app.css' );
		// $this->document->addStyle( 'view/stylesheet/select2/select2.min.css' );

		$data['heading_title'] = $this->language->get('heading_title');

		$name = 'status';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Status' ),
			'element' => $this->a->r( [
				'type'  => 'select',
				'value'  => $this->a->o()->status(),
				'active' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_v_url';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Video URL' ),
			'element' => $this->a->r( [
				'type'  => 'url',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_v_header1';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header line #1' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_v_header2';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header line #2' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_v_button';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Button\'s text' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_hiw_header';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_g_header';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_g_button';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Button\'s text' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_a_header';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_a_header_text';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header text' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_a_text';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Text' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_a_button';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Button\'s text' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'hp_a_image1';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Image #1' ),
			'element' => $this->a->r( [
				'type'   => 'image',
				'value'  => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
				'id'     => "about-$name-1",
			] ),
		] );

		$name = 'hp_a_image2';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Image #2' ),
			'element' => $this->a->r( [
				'type'   => 'image',
				'value'  => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
				'id'     => "about-$name-2",
			] ),
		] );

		$name = 'hp_r_header';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'footer_text';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Text' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'footer_cf_header';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'footer_cf_button';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Button\'s text' ),
			'element' => $this->a->r( [
				'type'  => 'text',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$attributes = [];

		foreach( $this->model_catalog_attribute->getAttributes() as $o ) {
			$attributes[ $o['attribute_id'] ] = $o['name'];
		}

		$name = 'material';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Material attribute' ),
			'element' => $this->a->r( [
				'type'   => 'select',
				'value'  => $attributes,
				'active' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$options = [];

		foreach( $this->model_catalog_option->getOptions() as $o ) {
			$options[ $o['option_id'] ] = $o['name'];
		}

		$name = 'your_size';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( '"Your size" option' ),
			'element' => $this->a->r( [
				'type'   => 'select',
				'value'  => $options,
				'active' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'your_size_min';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( '"Your size" minimum' ),
			'element' => $this->a->r( [
				'type'   => 'number',
				'value'  => $this->a->get_value_from_post( $name, 10 ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'your_size_max';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( '"Your size" maximum' ),
			'element' => $this->a->r( [
				'type'   => 'number',
				'value'  => $this->a->get_value_from_post( $name, 15 ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'length';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( '"Length" option' ),
			'element' => $this->a->r( [
				'type'   => 'select',
				'value'  => $options,
				'active' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'length_min';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( '"Length" minimum' ),
			'element' => $this->a->r( [
				'type'   => 'number',
				'value'  => $this->a->get_value_from_post( $name, 10 ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'length_max';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( '"Length" maximum' ),
			'element' => $this->a->r( [
				'type'   => 'number',
				'value'  => $this->a->get_value_from_post( $name, 20 ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'about_1_header';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header' ),
			'element' => $this->a->r( [
				'type'  => 'textarea',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'about_1_text';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Text' ),
			'element' => $this->a->r( [
				'type'  => 'textarea',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'about_1_image1';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Image #1' ),
			'element' => $this->a->r( [
				'type'   => 'image',
				'value'  => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
				'id'     => "about-$name-1",
			] ),
		] );

		$name = 'about_1_image2';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Image #2' ),
			'element' => $this->a->r( [
				'type'   => 'image',
				'value'  => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
				'id'     => "about-$name-2",
			] ),
		] );

		$name = 'about_2_text';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Text' ),
			'element' => $this->a->r( [
				'type'  => 'textarea',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'about_2_image';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Image #1' ),
			'element' => $this->a->r( [
				'type'   => 'image',
				'value'  => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
				'id'     => "about-$name-1",
			] ),
		] );

		$name = 'about_3_header';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header' ),
			'element' => $this->a->r( [
				'type'  => 'textarea',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'about_3_text';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Text' ),
			'element' => $this->a->r( [
				'type'  => 'textarea',
				'value' => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'about_3_image';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Image #1' ),
			'element' => $this->a->r( [
				'type'   => 'image',
				'value'  => $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
				'id'     => "about-$name-1",
			] ),
		] );

		$name = 'terms_header';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Header' ),
			'element' => $this->a->r( [
				'type'   => 'text',
				'value'  =>  htmlspecialchars_decode( $this->a->get_value_from_post( $name ) ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'social_fb_id';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'ID' ),
			'element' => $this->a->r( [
				'type'   => 'text',
				'value'  =>  $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'social_fb_secret';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Secret' ),
			'element' => $this->a->r( [
				'type'   => 'text',
				'value'  =>  $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'social_g_id';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'ID' ),
			'element' => $this->a->r( [
				'type'   => 'text',
				'value'  =>  $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$name = 'social_g_secret';
		$data[ $name ] = $this->a->r()->render_form_group( [
			'label' => $this->a->__( 'Secret' ),
			'element' => $this->a->r( [
				'type'   => 'text',
				'value'  =>  $this->a->get_value_from_post( $name ),
				'class'  => 'form-control',
				'name'   => $name,
			] ),
		] );

		$data['hp_hiw_steps'] = $this->model->get_template( 'hp_hiw_steps' );
		$data['hp_review' ] = $this->model->get_template( 'hp_review' );
		$data['footer_links'] = $this->model->get_template( 'footer_links' );
		$data['faq'] = $this->model->get_template( 'faq' );
		$data['terms'] = $this->model->get_template( 'terms' );
		$data['menu'] = $this->model->get_template( 'menu' );
		$data['size'] = $this->model->get_template( 'size' );

		$data['locale'] = json_encode( array(
			'hp_hiw_steps'              => $this->model->line_hp_hiw_steps( 'hp_hiw_steps' ),
			'hp_review'                 => $this->model->line_hp_review( 'hp_review' ),
			'footer_links'              => $this->model->line_footer_links( 'footer_links' ),
			'faq'                       => $this->model->line_faq( 'faq' ),
			'terms'                     => $this->model->line_terms( 'terms' ),
			'menu'                      => $this->model->line_menu( 'menu' ),
			'size'                      => $this->model->line_size( 'size' ),

			// Common stuff
			'networkError'              => $this->a->__( 'Network error' ),
			'parseError'                => $this->a->__( 'Unable to parse server response string' ),
			'undefServerResp'           => $this->a->__( 'Undefined server response' ),
			'serverError'               => $this->a->__( 'Server error' ),
			'sessionExpired'            => $this->a->__( 'Current session has expired' ),
			'modalHeader'               => 'Stripe',
			'yes'                       => $this->a->__( 'Yes' ),
			'no'                        => $this->a->__( 'No' ),
			'clipboard'                 => '',
		) );


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->a->u(),
		);

		$data['action'] = $this->a->u()->url();

		$data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=theme', true);

		if (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$setting_info = $this->model_setting_setting->getSetting('arbole', $this->request->get['store_id']);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view( $this->a->type .'/'. $this->a->code, $data) );
	}

	public function get_next_count( $data ) {
		if ( is_array( $data ) && is_array( current( $data ) ) ) {
			$t = array_keys( $data );
			return array_pop( $t );
		}

		return 0;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->a->full_name ) ) {
			$this->error['warning'] = $this->a->__( 'You have no permissions to modify settings' );
		}

		// if ( ! $this->request->post['arbole_general_item_count'] || $this->request->post['arbole_general_item_count'] > 5 || $this->request->post['arbole_general_item_count'] < 2 ) {
		// 	$this->error['general_item_count'] = $this->language->get('error_general_item_count');
		// }

		// if ( ! $this->request->post['arbole_general_line_count'] ) {
		// 	$this->error['general_line_count'] = $this->language->get('error_general_line_count');
		// }

		return !$this->error;
	}

	public function product_autocomplete() {
		$ret = array();

		try {
			if ( ! isset( $this->request->get['name'] ) ) {
				throw new Exception( 'name is missing' );
			}

			if ( ! isset( $this->request->get['cat'] ) ) {
				throw new Exception( 'category is missing' );
			}

			$this->load->model( 'extension/theme/arbole' );
			$ret = $this->model_extension_theme_arbole->get_products_by_name( $this->request->get['cat'], $this->request->get['name'] );

		} catch ( Exception $e ) {
			echo $e->getMessage();

		}

		$this->response->setOutput( json_encode( $ret ) );
	}

	public function install() {
		$this->model->add_tables();
		$this->model->fix_tables();
	}

	public function uninstall() {
		$this->a->remove_db();
	}

	public function save_template() {
		$this->load->model( 'extension/theme/arbole' );
		$ret = array();
		$post = $this->request->post;

		$id = isset( $post['id'] ) ? $post['id'] : '';
		$name = isset( $post['name'] ) ? $post['name'] : '';
		$thumb = isset( $post['thumb'] ) ? $post['thumb'] : '';
		$json = isset( $post['json'] ) ? $post['json'] : '';

		try {

			if ( ! $thumb ) {
				throw new arboleException( 'Preview image is missing' );
			}

			if ( ! $json ) {
				throw new arboleException( 'Template JSON is missing' );
			}

			// if ( ! @json_decode( $json ) ) {
			// 	throw new arboleException( 'Invalid JSON format' );
			// }

			if ( $ret_id = $this->model_extension_theme_arbole->save_template( array(
					'id'    => $id,
					'name'  => $name,
					'thumb' => $thumb,
					'json'  => $json,
			  )	)
			) {
				$ret['success'] = 'true';
				$ret['id'] = $ret_id;
			}

		} catch ( arboleException $e ) {
			$ret['error'] = $e->getMessage();
		}

		$this->response->setOutput( json_encode( $ret ) );
	}

	public function get_menu_row_temptale( $name_prefix, $id = '{id}', $data = array() ) {
		$name = isset( $data['name'] ) ? $data['name'] : '';
		$url = isset( $data['url'] ) ? $data['url'] : '';
		$text_text = $this->language->get('text_text');
		$text_url = $this->language->get('text_url');

		$ret = <<<HTML
<div class="row" style="margin-bottom: 5px">
	<div class="col-sm-5">
		<input type="text" name="{$name_prefix}[{$id}][name]" class="form-control" value="{$name}" placeholder="{$text_text}">
	</div>
	<div class="col-sm-5">
		<input type="text" name="{$name_prefix}[{$id}][url]" class="form-control" value="{$url}" placeholder="{$text_url}">
	</div>
	<div class="col-sm-2">
		<button type="button" class="btn btn-danger remove-menu-row"><i class="fa fa-close"></i></button>
	</div>
</div>
HTML;
	
	return $ret;
	}

	public function render_menu( $name_prefix, $data ) {
		$ret = '';

		if ( ! is_array( $data ) ) {
			return $ret;
		}

		foreach( $data as $id => $v ) {
			$ret .= $this->get_menu_row_temptale( $name_prefix, $id, $v );
		}

		return $ret;
	}

	public function special() {
		$id = 0;
		$ret = '<div class="special-data">';
		
		foreach( (array)$this->config->get( 'arbole_special' ) as $id => $data ) {
			$ret .= $this->special_line( $id, $data );
		}
			
		$ret .= '<input type="hidden" id="special-count" value="' . $id . '">';

		$ret .= <<<HTML
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">{$this->language->get('text_add_special')}</label>
	<div class="col-sm-10">
		<button type="button" id="special-add" class="btn btn-primary" type="button"><i class="fa fa-plus">{$this->language->get('text_add')}</i></button>
	</div>
</div>
HTML;

		return $ret;
	}

	public function special_line( $id = '{replace}', $data = array() ) {
		$this->load->language( 'theme/arbole' );
		$this->load->model( 'tool/image' );

		$header1 = isset( $data['header1'] ) ? $data['header1'] : '';
		$header2 = isset( $data['header2'] ) ? $data['header2'] : '';
		$text = isset( $data['text'] ) ? $data['text'] : '';
		$image = isset( $data['img'] ) ? $data['img'] : '';
		$url = isset( $data['url'] ) ? $data['url'] : '';
		$placeholder = $this->model_tool_image->resize( 'no_image.png', 100, 100 );
		$thumb = ( $image && is_file( DIR_IMAGE . $image ) ) ? $this->model_tool_image->resize( $image, 100, 100) : $placeholder;
		$date_from = isset( $data['date_from'] ) ? $data['date_from'] : '';
		$date_to = isset( $data['date_to'] ) ? $data['date_to'] : '';
		$duration = isset( $data['duration'] ) ? $data['duration'] : '';

		$ret = <<<HTML
<div class="special-item remove-item">
	<div class="form-group">
		<label class="col-sm-2 control-label" for="special-{$id}-header1">{$this->language->get('text_special_header1')}</label>
		<div class="col-sm-10">
			<input name="arbole_special[{$id}][header1]" class="form-control" id="banner-{$id}-header1" value="{$header1}">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="special-{$id}-header2">{$this->language->get('text_special_header2')}</label>
		<div class="col-sm-10">
			<input name="arbole_special[{$id}][header2]" class="form-control" id="banner-{$id}-header2" value="{$header2}">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="special-{$id}-duration">{$this->language->get('text_duration')}</label>
		<div class="col-sm-10">
			<input name="arbole_special[{$id}][duration]" class="form-control" id="banner-{$id}-duration" value="{$duration}">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="special-{$id}-date-from">{$this->language->get('text_date_from')}</label>
		<div class="col-sm-10">
			<div class="input-group date">
				<input name="arbole_special[{$id}][date_from]" class="form-control" id="special-{$id}-date-from" type="text" value="{$date_from}" data-date-format="YYYY/MM/DD HH:mm">
				<span class="input-group-btn">
					<button class="btn btn-default"><i class="fa fa-calendar" type="button"></i></button>
				</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="special-{$id}-date-to">{$this->language->get('text_date_to')}</label>
		<div class="col-sm-10">
			<div class="input-group date">
				<input name="arbole_special[{$id}][date_to]" class="form-control" id="special-{$id}-date-to" type="text" value="{$date_to}" data-date-format="YYYY/MM/DD HH:mm">
				<span class="input-group-btn">
					<button class="btn btn-default"><i class="fa fa-calendar" type="button"></i></button>
				</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="special-{$id}-text">{$this->language->get('text_text')}</label>
		<div class="col-sm-10">
			<textarea name="arbole_special[{$id}][text]" class="form-control" id="special-{$id}-text">{$text}</textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="special-{$id}-url">{$this->language->get('text_url')}</label>
		<div class="col-sm-10">
			<div class="input-group">
				<span class="input-group-addon">http://</span>
				<input name="arbole_special[{$id}][url]" class="form-control" id="special-{$id}-url" type="text" value="{$url}">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">{$this->language->get('text_image')}</label>
		<div class="col-sm-10">
			<a href="" id="special-{$id}-img" data-toggle="image" class="img-thumbnail">
				<img src="{$thumb}" alt="" title="" data-placeholder="{$placeholder}">
			</a>
			<input type="hidden" name="arbole_special[{$id}][img]" value="{$image}" id="input-{$id}-img">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">{$this->language->get('text_delete')}</label>
		<div class="col-sm-10">
			<button type="button" class="btn btn-danger remove-list-item"><i class="fa fa-close"></i></button>
		</div>
	</div>
	<hr>
</div>
HTML;

		return $ret;
	}
}

if ( ! class_exists( 'arboleException' ) ) {
	class arboleException extends Exception {

	}
}
