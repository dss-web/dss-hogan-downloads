<?php
/**
 * Template for dss downloads module
 *
 * $this is an instance of the DSS_Downloads object.
 *
 * Available properties:
 * $this->downloads (array) Array containing all download items.
 *
 * @package Hogan
 */
declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof DSS_Downloads ) ) {
	return; // Exit if accessed directly.
}
?>

<ul>
	<?php foreach ( $this->downloads as $download ) : ?>
		<li>
			<?php
			$title                          = $download['title'] ?: esc_html__( 'Download the file', 'hogan-dss-downloads' );
			$file                           = ( isset( $download['file'] ) ? $download['file'] : false );
			$file_url                       = ( ( $file && isset( $file['url'] ) ) ? $file['url'] : false );
			$file_name                      = ( ( $file && isset( $file['filename'] ) ) ? $file['filename'] : false );
			$file_mime_type                 = ( ( $file && isset( $file['mime_type'] ) ) ? $file['mime_type'] : false );
			$file_id                        = ( ( $file && isset( $file['id'] ) ) ? $file['id'] : false );
			$attachment_file_path           = get_attached_file( $file_id );
			$attachment_file_size_formatted = '';
			if ( false !== $attachment_file_path && file_exists( $attachment_file_path ) && is_readable( $attachment_file_path ) ) :
				$attachment_file_size           = filesize( $attachment_file_path );
				$attachment_file_size_formatted = size_format( $attachment_file_size );
			endif;
			$max_chars = 50;
			if ( strlen( $file_name ) > $max_chars ) {
				$mime_type_array   = explode( '/', $file_mime_type );
				$mime_type         = $mime_type_array[ count( $mime_type_array ) - 1 ];
				$file_name_chopped = substr( $file_name, 0, ( $max_chars - 3 ) ) . '...' . $mime_type;
			} else {
				$file_name_chopped = $file_name;
			}
			?>
			<p><a href="<?php echo $file_url; ?>" class="title" title="<?php echo $file_name; ?>"
				  download><?php echo $title; ?></a><br>
				<span class="file-info"><?php echo $file_name_chopped . ' | ' . $attachment_file_size_formatted; ?></span>
			</p>
		</li>
	<?php endforeach; ?>
</ul>
