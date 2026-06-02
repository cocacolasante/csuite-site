<?php
/**
 * CSuite Code - Google tag (gtag.js) for Google Ads / GA4
 * Loaded as a must-use plugin.
 *
 * Injects the Google tag into the <head> of every front-end page so the base
 * tag fires sitewide and conversions (e.g. the /thank-you/ pageview) are
 * tracked. Loads for all visitors; only the wp-admin dashboard is skipped so
 * the tag is verifiable with Google Tag Assistant even while logged in.
 * Safe to delete to revert.
 *
 * @package csuite
 */

defined( 'ABSPATH' ) || exit;

// Google tag ID. Override in wp-config.php by defining CSUITE_GTAG_ID.
defined( 'CSUITE_GTAG_ID' ) || define( 'CSUITE_GTAG_ID', 'G-ED2BR6XRY3' );

add_action( 'wp_head', function () {
	if ( is_admin() ) {
		return;
	}

	$id = CSUITE_GTAG_ID;
	if ( empty( $id ) ) {
		return;
	}

	$id_attr = esc_attr( $id );
	$id_js   = esc_js( $id );
	?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $id_attr; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $id_js; ?>');
</script>
<!-- End Google tag -->
	<?php
}, 1 );
