<?php
/**
 * Template for dss downloads module
 *
 * $this is an instance of the DSS_Downloads object.
 *
 * Available properties:
 * $this->downloads (array) Array containing all download items.
 * $this->preview_image (string) If a preview image should be displayed or a generic icon.
 *
 * @package Hogan
 */
declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof DSS_Downloads ) ) {
	return; // Exit if accessed directly.
}

if ( ! \function_exists( 'Dekode\\Hogan\\render_dss_hogan_download_item' ) ) {
	/**
	 * Helper to render a download file item.
	 *
	 * @param array $download array with info about the item.
	 *
	 * @return string String to render.
	 */
	function render_dss_hogan_download_item( array $download ) : string {
		$output = '';
		// Bail early if can't find the file. Is required, but is added for extra security.
		$file = isset( $download['file'] ) ? $download['file'] : false;
		if ( empty( $file ) ) {
			return '';
		}
		$file_url             = isset( $file['url'] ) ? $file['url'] : '#';
		$file_name            = isset( $file['filename'] ) ? $file['filename'] : '';
		$file_id              = isset( $file['id'] ) ? $file['id'] : 0;
		$attachment_file_path = get_attached_file( $file_id );
		$title                = $download['file_title'] ?: esc_html__( 'Download the file', 'dss-hogan-downloads' );

		// Get the mime and add to the download item title.
		if ( ! empty( $file_name ) ) {
			$mime_type_array = explode( '.', $file_name );
			$mime_type       = $mime_type_array[ count( $mime_type_array ) - 1 ];
			$title           .= sprintf( ' i %s format', esc_html( $mime_type ) );
		}

		if ( false !== $attachment_file_path && file_exists( $attachment_file_path ) && is_readable( $attachment_file_path ) ) :
			$attachment_file_size           = filesize( $attachment_file_path );
			$attachment_file_size_formatted = size_format( $attachment_file_size );
			$title                          .= sprintf( ' (%s)', esc_html( $attachment_file_size_formatted ) );
		endif;

		$title = apply_filters( 'dss/hogan/module/downloads/item/title', $title, $download );

		$output .= sprintf( '<a href="%s" title="%s" download>%s</a>', esc_url( $file_url ), esc_attr( $file_name ), esc_html( $title ) );

		return apply_filters( 'dss/hogan/module/downloads/item/output', $output, $file_url, $file_name, $title, $download );
	}
}

?>

<ul class="">
	<?php
	// loop box layout.
	foreach ( $this->downloads as $download ) : ?>
		<li class="">
			<?php
			// Box title.
			$box_title = $download['title'] ?: esc_html__( 'Download files', 'dss-hogan-downloads' );
			printf( '<button class="longdoc-download active" data-toggle="[data-longdoc-download-list]" aria-expanded="true" aria-controls="jsDataLongdocDownloadList">%s</button>', esc_html( $box_title ) );
			?>
			<ul>
				<li>
					<?php echo render_dss_hogan_download_item( $download ); ?>
				</li>
				<?php
				// Render additional files if any.
				if ( ! empty( $download['additional_files'] ) ) :
					foreach ( $download['additional_files'] as $additional_file ) : ?>
						<li>
							<?php echo render_dss_hogan_download_item( $additional_file ); ?>
						</li>
					<?php
					endforeach;
				endif;
				?>
			</ul>
		</li>
	<?php endforeach; ?>
</ul>
