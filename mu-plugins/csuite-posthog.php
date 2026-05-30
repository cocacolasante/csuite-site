<?php
/**
 * CSuite Code - PostHog product analytics
 * Loaded as a must-use plugin.
 *
 * Injects the PostHog snippet into the site <head> for visitor analytics.
 * Skips the WP admin and logged-in users so internal activity does not
 * pollute the data. Safe to delete to revert.
 *
 * @package csuite
 */

defined( 'ABSPATH' ) || exit;

/*
 * Configuration.
 *
 * CSUITE_POSTHOG_KEY  - Public project API key (starts with "phc_"). This is a
 *                       client-side key and is safe to ship in page source; it is
 *                       NOT a private/personal API key.
 * CSUITE_POSTHOG_HOST - API host for your region:
 *                         US -> https://us.i.posthog.com
 *                         EU -> https://eu.i.posthog.com
 *
 * Either edit the defaults below, or define the same constants in wp-config.php
 * to override them without touching this file.
 */
defined( 'CSUITE_POSTHOG_KEY' )  || define( 'CSUITE_POSTHOG_KEY', 'phc_oWiP4Vot8oFPr6Rr5vqcjT74uFGb3yMUHtkHsA9kUeBx' );
defined( 'CSUITE_POSTHOG_HOST' ) || define( 'CSUITE_POSTHOG_HOST', 'https://us.i.posthog.com' );

add_action( 'wp_head', function () {
	// Don't track the admin area or signed-in users (editing / testing).
	if ( is_admin() || is_user_logged_in() ) {
		return;
	}

	$key  = CSUITE_POSTHOG_KEY;
	$host = CSUITE_POSTHOG_HOST;

	// Bail until a real key has been configured.
	if ( empty( $key ) || 'REPLACE_WITH_phc_KEY' === $key ) {
		return;
	}

	$key_js  = wp_json_encode( $key );
	$host_js = wp_json_encode( esc_url_raw( $host ) );
	?>
<!-- PostHog (CSuite Code) -->
<script>
	!function(t,e){var o,n,p,r;e.__SV||(window.posthog=e,e._i=[],e.init=function(i,s,a){function g(t,e){var o=e.split(".");2==o.length&&(t=t[o[0]],e=o[1]),t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}}(p=t.createElement("script")).type="text/javascript",p.crossOrigin="anonymous",p.async=!0,p.src=s.api_host.replace(".i.posthog.com","-assets.i.posthog.com")+"/static/array.js",(r=t.getElementsByTagName("script")[0]).parentNode.insertBefore(p,r);var u=e;for(void 0!==a?u=e[a]=[]:a="posthog",u.people=u.people||[],u.toString=function(t){var e="posthog";return"posthog"!==a&&(e+="."+a),t||(e+=" (stub)"),e},u.people.toString=function(){return u.toString(1)+".people (stub)"},o="init capture register register_once register_for_session unregister unregister_for_session getFeatureFlag getFeatureFlagPayload isFeatureEnabled reloadFeatureFlags updateEarlyAccessFeatureEnrollment getEarlyAccessFeatures on onFeatureFlags onSessionId getSurveys getActiveMatchingSurveys renderSurvey canRenderSurvey getNextSurveyStep identify setPersonProperties group resetGroups setPersonPropertiesForFlags resetPersonPropertiesForFlags setGroupPropertiesForFlags resetGroupPropertiesForFlags reset get_distinct_id getGroups get_session_id get_session_replay_url alias set_config startSessionRecording stopSessionRecording sessionRecordingStarted captureException loadToolbar get_property getSessionProperty createPersonProfile opt_in_capturing opt_out_capturing has_opted_in_capturing has_opted_out_capturing clear_opt_in_out_capturing debug getPageViewId captureTraceFeedback captureTraceMetric".split(" "),n=0;n<o.length;n++)g(u,o[n]);e._i.push([i,s,a])},e.__SV=1)}(document,window.posthog||[]);
	posthog.init(<?php echo $key_js; ?>, {
		api_host: <?php echo $host_js; ?>,
		person_profiles: 'identified_only',
		defaults: '2025-05-24',
		disable_session_recording: false
	});
</script>
<!-- /PostHog -->
	<?php
}, 5 );
