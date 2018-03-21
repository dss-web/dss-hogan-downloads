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
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [
				[
					'type'         => 'repeater',
					'key'          => $this->field_key . '_downloads',
					'label'        => __( 'Downloads', 'dss-hogan-downloads' ),
					'name'         => 'downloads',
					'instructions' => __( 'Create a list of downloadable files', 'dss-hogan-downloads' ),
					'collapsed'    => '',
					'min'          => 1,
					'max'          => 0,
					'layout'       => 'table',
					'button_label' => __( 'Add download', 'dss-hogan-downloads' ),
					'sub_fields'   => [
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
							'type'          => 'file',
							'key'           => $this->field_key . '_file',
							'label'         => __( 'File', 'dss-hogan-downloads' ),
							'name'          => 'file',
							'instructions' => apply_filters( 'dss/hogan/module/downloads/title/instructions', esc_html_x( 'Allowed file types', 'ACF Instruction', 'dss-hogan-downloads' ) ) . ': ' . apply_filters( 'dss/hogan/module/downloads/mime_types', '.pdf' ),
							'required'      => 1,
							'wrapper'       => [
								'width' => '50',
							],
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
		 * @param int $counter Module location in page layout.
		 *
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->downloads = $raw_content['downloads'];

			parent::load_args_from_layout_content( $raw_content, $counter );
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
