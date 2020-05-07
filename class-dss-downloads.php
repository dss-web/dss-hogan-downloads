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

			return [
				[
					'type'         => 'repeater',
					'key'          => $this->field_key . '_downloads',
					'label'        => __( 'Downloads', 'dss-hogan-downloads' ),
					'name'         => 'downloads',
					'instructions' => __( 'Create one or multiple lists of downloads', 'dss-hogan-downloads' ),
					'collapsed'    => '',
					'min'          => 1,
					'max'          => 0,
					'layout'       => 'block',
					'button_label' => __( 'Add downloads', 'dss-hogan-downloads' ),
					'sub_fields'   => [
						[
							'key'          => $this->field_key . '_download_item',
							'label'        => __( 'Download', 'dss-hogan-downloads' ),
							'name'         => 'download_item',
							'type'         => 'accordion',
							'open'         => 1,
							'multi_expand' => 1,
						],
						[
							'type'         => 'text',
							'key'          => $this->field_key . '_title',
							'label'        => __( 'Box title', 'dss-hogan-downloads' ),
							'name'         => 'title',
							'instructions' => apply_filters( 'dss/hogan/module/downloads/title/instructions', esc_html_x( 'Optional box title for the files. If not filled in "Download files" is used as title.', 'ACF Instruction', 'dss-hogan-downloads' ) ),
						],
						[
							'type'          => 'file',
							'key'           => $this->field_key . '_file',
							'label'         => __( 'File', 'dss-hogan-downloads' ),
							'name'          => 'file',
							'instructions'  => apply_filters( 'dss/hogan/module/downloads/title/instructions', esc_html_x( 'Allowed file types', 'ACF Instruction', 'dss-hogan-downloads' ) ) . ': ' . apply_filters( 'dss/hogan/module/downloads/mime_types', '.pdf' ),
							'required'      => 1,
							'return_format' => 'array',
							'library'       => 'all',
							'min_size'      => '',
							'max_size'      => '',
							'mime_types'    => apply_filters( 'dss/hogan/module/downloads/mime_types', '.pdf' ),
							'wrapper'       => [
								'width' => '50',
							],
						],
						[
							'type'         => 'text',
							'key'          => $this->field_key . '_file_title',
							'label'        => __( 'Title', 'dss-hogan-downloads' ),
							'name'         => 'file_title',
							'instructions' => apply_filters( 'dss/hogan/module/downloads/title/instructions', esc_html_x( 'Optional title for the file. If not filled in "Download the file" is used as title.', 'ACF Instruction', 'dss-hogan-downloads' ) ),
							'wrapper'      => [
								'width' => '50',
							],
						],
						[
							'type'         => 'repeater',
							'key'          => $this->field_key . '_additional_files',
							'label'        => __( 'Additional files', 'dss-hogan-downloads' ),
							'name'         => 'additional_files',
							'instructions' => __( 'Add more files and create a list of downloadable files', 'dss-hogan-downloads' ),
							'layout'       => 'block',
							'button_label' => __( 'Add files', 'dss-hogan-downloads' ),
							'sub_fields'   => [
								[
									'type'         => 'clone',
									'key'          => $this->field_key . '_additional_file',
									'label'        => __( 'Test clone', 'nettsteder-mal' ),
									'name'         => 'additional_file',
									'required'     => 0,
									'clone'        => [
										0 => $this->field_key . '_file',
										1 => $this->field_key . '_file_title',
									],
									'display'      => 'seamless',
									'layout'       => 'block',
									'prefix_label' => 0,
									'prefix_name'  => 0,
								],
							],
						],
					],
				],
			];
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

			$this->downloads        = $raw_content['downloads'];

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
