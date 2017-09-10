<?php
class ModelExtensionThemeArbole extends Model {

	protected $thumb_dir = '';

	public function __construct( $registry ) {
		parent::__construct( $registry );
		$this->a = Advertikon\Arbole\Advertikon::instance();
		
		$this->thumb_dir = DIR_SYSTEM . 'storage/constructor/thumb/';
	}

	public function add_tables() {
		// $this->db->query(
		// 	"CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "giftart_customer`
		// 	(
		// 		`id`         INT(11)      UNSIGNED,
		// 		`date_birth` DATE,
		// 		`marital`    VARCHAR(255),
		// 		PRIMARY KEY(`id`)
		// 	)
		// 	ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin"
		// );

	}

	public function fix_tables() {
		$birth = $sex = false;
		$q = $this->db->query( "show columns from " . DB_PREFIX . "customer" );

		if ( $q && $q->num_rows ) {
			foreach( $q->rows as $row ) {
				if ( $row['Field'] === 'is_male' ) {
					$sex = true;

				} else if ( $row['Field'] === 'birth' ) {
					$birth = true;
				}
			}

			if ( !$birth ) {
				$this->db->query( "alter table " . DB_PREFIX . "customer add birth date default null" );
			}

			if ( !$sex ) {
				$this->db->query( "alter table " . DB_PREFIX . "customer add is_male tinyint default 1" );
			}
		}
	}

	public function get_template( $name ) {
		$ret = <<<HTML
<div class="form-group template-container">
	<lable class="col-sm-2"></lable>
	<div class="col-sm-10">
		<div class="template-content">
HTML;

		$data = $this->a->config( $name, [] );

		foreach( $data as $id => $line ) {
			$ret .= $this->{"line_" . $name}( $name, $id, $line );
		}

		$ret .= <<<HTML
		</div>
		<div class="pull-right">
		{$this->a->r( [
			'type'        => 'button',
			'button_type' => 'primary',
			'icon'        => 'fa-plus',
			'text_after'  => $this->a->__( 'Add new' ),
			'class'       => 'add-line',
			'custom_data' => "data-count=\"{$this->get_max_count( $data )}\"
								data-name=\"{$name}\"",
		] )}
		</div>
	</div>
</div>
HTML;

		return $ret;
	}

	public function get_max_count( array $data ) {
		if ( count( $data ) === 0 ) return 0;

		$count = max( array_keys( $data ) );

		return ++$count;
	}

	public function line_hp_hiw_steps( $name, $id = '{id}', $data = [] ) {
		$ret = <<<HTML
<div class="row template-line">
	<div class="col-sm-5">
		{$this->a->r( [
			'type'        => 'text',
			'class'       => 'form-control',
			'value'       => isset( $data['text'] ) ? htmlspecialchars_decode( $data['text'] ) : '',
			'placeholder' => $this->a->__( 'Caption' ),
			'name'        => "{$name}[{$id}][text]",
		] )}
	</div>
	<div class="col-sm-5">
		{$this->a->r( [
			'type'        => 'image',
			'class'       => 'form-control',
			'value'       => isset( $data['image'] ) ? $data['image'] : '',
			'name'        => "{$name}[{$id}][image]",
			'id'          => "steps-$id",

		] )}
	</div>
	<div class="col-sm-2">
		{$this->a->r( [
			'type'        => 'button',
			'button_type' => 'danger',
			'icon'        => 'fa-close',
			'class'       => 'remove-line',
		] )}
	</div>
</div>
HTML;
		return $ret;
	}

	public function line_hp_review( $name, $id = '{id}', $data = [] ) {
		$ret = <<<HTML
<div class="row template-line">
	<div class="col-sm-3">
		{$this->a->r( [
			'type'        => 'text',
			'class'       => 'form-control',
			'value'       => isset( $data['header'] ) ? htmlspecialchars_decode( $data['header'] ) : '',
			'placeholder' => $this->a->__( 'Customer' ),
			'name'        => "{$name}[{$id}][header]",
		] )}
	</div>
	<div class="col-sm-3">
		{$this->a->r( [
			'type'        => 'textarea',
			'class'       => 'form-control',
			'value'       => isset( $data['text'] ) ? htmlspecialchars_decode( $data['text'] ) : '',
			'name'        => "{$name}[{$id}][text]",
			'placeholder' => $this->a->__( 'Text' ),
			'id'          => $id,

		] )}
	</div>
	<div class="col-sm-2">
		{$this->a->r( [
			'type'        => 'image',
			'class'       => 'form-control',
			'value'       => isset( $data['image1'] ) ? $data['image1'] : '',
			'name'        => "{$name}[{$id}][image1]",
			'id'          => "review-$id-1",

		] )}
	</div>
	<div class="col-sm-2">
		{$this->a->r( [
			'type'        => 'image',
			'class'       => 'form-control',
			'value'       => isset( $data['image2'] ) ? $data['image2'] : '',
			'name'        => "{$name}[{$id}][image2]",
			'id'          => "review-$id-2",

		] )}
	</div>
	<div class="col-sm-2">
		{$this->a->r( [
			'type'        => 'button',
			'button_type' => 'danger',
			'icon'        => 'fa-close',
			'class'       => 'remove-line',
		] )}
	</div>
</div>
HTML;
		return $ret;
	}

	public function line_footer_links( $name, $id = '{id}', $data = [] ) {
		$ret = <<<HTML
<div class="row template-line">
	<div class="col-sm-5">
		{$this->a->r( [
			'type'        => 'text',
			'class'       => 'form-control',
			'value'       => isset( $data['name'] ) ? htmlspecialchars_decode( $data['name'] ) : '',
			'placeholder' => $this->a->__( 'Name' ),
			'name'        => "{$name}[{$id}][name]",
		] )}
	</div>
	<div class="col-sm-5">
		{$this->a->r( [
			'type'        => 'url',
			'class'       => 'form-control',
			'value'       => isset( $data['url'] ) ? htmlspecialchars_decode( $data['url'] ) : '',
			'placeholder' => $this->a->__( 'Url' ),
			'name'        => "{$name}[{$id}][url]",
		] )}
	</div>
	<div class="col-sm-2">
		{$this->a->r( [
			'type'        => 'button',
			'button_type' => 'danger',
			'icon'        => 'fa-close',
			'class'       => 'remove-line',
		] )}
	</div>
</div>
HTML;
		return $ret;
	}

	public function line_faq( $name, $id = '{id}', $data = [] ) {
		$ret = <<<HTML
<div class="row template-line">
	<div class="col-sm-5">
		{$this->a->r( [
			'type'        => 'text',
			'class'       => 'form-control',
			'value'       => isset( $data['question'] ) ? htmlspecialchars_decode( $data['question'] ) : '',
			'name'        => "{$name}[{$id}][question]",
			'placeholder' => $this->a->__( 'Question' ),
			'id'          => $id,

		] )}
	</div>
	<div class="col-sm-6">
		{$this->a->r( [
			'type'        => 'textarea',
			'class'       => 'form-control',
			'value'       => isset( $data['answer'] ) ? htmlspecialchars_decode( $data['answer'] ) : '',
			'name'        => "{$name}[{$id}][answer]",
			'placeholder' => $this->a->__( 'Answer' ),
			'id'          => $id,

		] )}
	</div>
	<div class="col-sm-1">
		{$this->a->r( [
			'type'        => 'button',
			'button_type' => 'danger',
			'icon'        => 'fa-close',
			'class'       => 'remove-line',
		] )}
	</div>
</div>
HTML;
		return $ret;
	}
}
