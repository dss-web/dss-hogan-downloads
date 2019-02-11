<?php
/**
 * DSS Downloads module class
 *
 * @package Hogan
 */

declare( strict_types = 1 );

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\DSS_Downloads' ) && class_exists( '\\Dekode\\Hogan\\Module' ) ) {

	/**
	 * Simple Posts module class (WYSIWYG).
	 *
	 * @extends Modules base class.
	 */
	class DSS_Downloads extends Module {

		/**
		 * Preview image
		 *
		 * @var string
		 */
		public $preview_image = 'off';

		/**
		 * List of downloads.
		 *
		 * @var $downloads
		 */
		public $downloads;

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Downloads', 'dss-hogan-downloads' );
			$this->template = __DIR__ . '/assets/template.php';

			parent::__construct();
		}

		/**
		 * Enqueue module assets
		 */
		public function enqueue_assets() {
			wp_enqueue_style( 'dss-hogan-downloads', plugins_url( '/assets/css/dss-hogan-downloads.css', __FILE__ ), [], '1.2.0' );
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [
				[
					'type'          => 'button_group',
					'key'           => $this->field_key . '_preview_image',
					'name'          => 'preview_image',
					'label'         => __( 'Show preview image', 'dss-hogan-downloads' ),
					'instructions'  => __( 'Set \'On\' to show a preview image of the files. \'Off\' will show a download icon.', 'dss-hogan-downloads' ),
					'default_value' => 'off',
					'choices'       => [
						'off' => __( 'Off', 'dss-hogan-downloads' ),
						'on'  => __( 'On', 'dss-hogan-downloads' ),
					],
					'layout'        => 'horizontal',
					'return_format' => 'value',
				],
				[
					'type'         => 'repeater',
					'key'          => $this->field_key . '_downloads',
					'label'        => __( 'Downloads', 'dss-hogan-downloads' ),
					'name'         => 'downloads',
					'instructions' => __( 'Create a list of downloadable files', 'dss-hogan-downloads' ),
					'collapsed'    => '',
					'min'          => 1,
					'max'          => 0,
					'layout'       => 'block',
					'button_label' => __( 'Add download', 'dss-hogan-downloads' ),
					'sub_fields'   => [
						[
							'key' => $this->field_key . '_download_item',
							'label' => __( 'Download', 'dss-hogan-downloads' ),
							'name' => 'download_item',
							'type' => 'accordion',
							'open' => 1,
							'multi_expand' => 1,
						],
						[
							'type'         => 'text',
							'key'          => $this->field_key . '_title',
							'label'        => __( 'Title', 'dss-hogan-downloads' ),
							'name'         => 'title',
							'instructions' => apply_filters( 'dss/hogan/module/downloads/title/instructions', esc_html_x( 'Optional. If not filled in "Download the file" is used as title.', 'ACF Instruction', 'dss-hogan-downloads' ) ),

							'wrapper' => [
								'width' => '50',
							],
						],
						[
							'type'         => 'textarea',
							'key'          => $this->field_key . '_description',
							'name'         => 'description',
							'label'        => __( 'Description', 'dss-hogan-downloads' ),
							'instructions' => __( 'Add a short description', 'dss-hogan-downloads' ),
							'wrapper'       => [
								'width' => '50',
							],
							'required'     => false,
							'rows'         => 3,
							'new_lines'    => '',
						],
						[
							'type'          => 'file',
							'key'           => $this->field_key . '_file',
							'label'         => __( 'File', 'dss-hogan-downloads' ),
							'name'          => 'file',
							'instructions'  => apply_filters( 'dss/hogan/module/downloads/title/instructions', esc_html_x( 'Allowed file types', 'ACF Instruction', 'dss-hogan-downloads' ) ) . ': ' . apply_filters( 'dss/hogan/module/downloads/mime_types', '.pdf' ),
							'required'      => 1,
							'return_format' => 'array', //'url',
							'library'       => 'all',
							'min_size'      => '',
							'max_size'      => '',
							'mime_types'    => apply_filters( 'dss/hogan/module/downloads/mime_types', '.pdf' ),
						],
					],
				],
			];

			return $fields;
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int   $counter Module location in page layout.
		 *
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			parent::load_args_from_layout_content( $raw_content, $counter );

			if ( ! empty( $raw_content['preview_image'] ) ) {
				$this->preview_image = $raw_content['preview_image'];
			}

			$this->downloads = $raw_content['downloads'];

		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args() : bool {
			return ! empty( $this->downloads );
		}


	}
} // End if().
