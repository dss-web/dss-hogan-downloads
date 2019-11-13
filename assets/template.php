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

$ul_class = ( isset( $this->preview_image ) && 'on' === $this->preview_image ) ? 'image_preview' : 'icon_preview';
?>

<ul class="<?php echo esc_attr( $ul_class ); ?>">
	<?php foreach ( $this->downloads as $download ) : ?>
		<li>
			<?php
			$title                          = $download['title'] ?: esc_html__( 'Download the file', 'dss-hogan-downloads' );
			$file                           = ( isset( $download['file'] ) ? $download['file'] : false );
			$file_url                       = ( ( $file && isset( $file['url'] ) ) ? $file['url'] : false );
			$file_name                      = ( ( $file && isset( $file['filename'] ) ) ? $file['filename'] : false );
			$file_id                        = ( ( $file && isset( $file['id'] ) ) ? $file['id'] : false );
			$attachment_file_path           = get_attached_file( $file_id );
			$attachment_file_size_formatted = '';
			if ( false !== $attachment_file_path && file_exists( $attachment_file_path ) && is_readable( $attachment_file_path ) ) :
				$attachment_file_size           = filesize( $attachment_file_path );
				$attachment_file_size_formatted = size_format( $attachment_file_size );
			endif;
			$max_chars = apply_filters( 'dss/hogan/module/downloads/file_name_max_chars', 25 );
			if ( strlen( $file_name ) > $max_chars ) {
				$mime_type_array   = explode( '.', $file_name );
				$mime_type         = $mime_type_array[ count( $mime_type_array ) - 1 ];
				$file_name_chopped = substr( $file_name, 0, ( $max_chars - 3 ) ) . '...' . $mime_type;
			} else {
				$file_name_chopped = $file_name;
			}
			?>
			<div>
				<?php
				if ( isset( $this->preview_image ) && 'on' === $this->preview_image ) {
					$image = wp_get_attachment_image( $file_id, apply_filters( 'dss/hogan/module/downloads/preview_image_size', 'thumbnail' ) ) ?: sprintf( '<img src="%s" alt="%s">', apply_filters( 'dss/hogan/module/downloads/preview_image_fallback_icon_path', plugins_url( '/assets/images/document.png', dirname( __FILE__ ) ) ), esc_attr( 'Document preview image', 'dss-hogan-downloads' ) );
					printf(
						'<a href="%s" title="%s"
					   download>%s</a>',
						esc_url( $file_url ),
						esc_attr( $file_name ),
						$image
					);
				}
				?>
				<div>
					<?php
					printf(
						'<a href="%s" title="%s"
					   download>%s</a>',
						esc_url( $file_url ),
						esc_attr( $file_name ),
						esc_html( $title )
					);
					?>
					<br>
					<span class="file-info"><?php echo $file_name_chopped . ' | ' . $attachment_file_size_formatted; ?></span>
					<?php
					if ( isset( $download['description'] ) && ! empty( $download['description'] ) ) {
						printf( '<p>%s</p>', esc_textarea( $download['description'] ) );
					}
					?>
				</div>
			</div>
			</p>
		</li>
	<?php endforeach; ?>
</ul>
