<?php
/**
 * Plugin Name: CSuite Code Style Polish
 * Description: Lightweight visual polish on top of Kadence — hover lifts, focus rings, smoother transitions, tighter mobile rhythm.
 * Version: 1.0.0
 * Author: CSuite Code
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function () {
	?>
<style id="csuite-style-polish">
/* === Base typography polish === */
html { scroll-behavior: smooth; }
body { text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
::selection { background: var(--global-palette1, #1f6feb); color: var(--global-palette9, #fff); }

/* Tighter, more deliberate heading rhythm */
.entry-content h1,
.entry-content h2,
.kt-adv-heading-wrap h1,
.kt-adv-heading-wrap h2,
.wp-block-kadence-advancedheading h1,
.wp-block-kadence-advancedheading h2 {
	letter-spacing: -0.012em;
}

/* Body links — clearer affordance, smoother hover */
.entry-content a:not(.wp-block-button__link):not(.kb-button):not(.kt-blocks-info-box-link-wrap):not(.kb-svg-image-link) {
	text-decoration: underline;
	text-decoration-thickness: 1px;
	text-underline-offset: 3px;
	text-decoration-color: rgba(31, 111, 235, 0.35);
	transition: text-decoration-color 0.15s ease, color 0.15s ease;
}
.entry-content a:not(.wp-block-button__link):not(.kb-button):not(.kt-blocks-info-box-link-wrap):not(.kb-svg-image-link):hover {
	text-decoration-color: currentColor;
}

/* === Buttons — smoother transitions, lift on hover === */
.wp-block-kadence-singlebtn .kb-button,
.kb-buttons-wrap .kb-button,
.wp-block-button__link {
	transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, color 0.18s ease, border-color 0.18s ease !important;
	will-change: transform;
}
.wp-block-kadence-singlebtn .kb-button:hover,
.kb-buttons-wrap .kb-button:hover,
.wp-block-button__link:hover {
	transform: translateY(-1px);
}
.wp-block-kadence-singlebtn .kb-button:active,
.kb-buttons-wrap .kb-button:active,
.wp-block-button__link:active {
	transform: translateY(0);
}

/* === Infobox cards — substantive hover state === */
.wp-block-kadence-infobox .kt-info-box {
	transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease, background-color 0.22s ease;
	border: 1px solid transparent;
}
.wp-block-kadence-infobox:hover .kt-info-box {
	transform: translateY(-3px);
	box-shadow: 0 12px 32px -16px rgba(31, 111, 235, 0.25), 0 2px 8px -4px rgba(0,0,0,0.06);
	border-color: rgba(31, 111, 235, 0.18);
}
/* Icon background shift on hover for cards that use stacked icons */
.wp-block-kadence-infobox .kadence-info-box-icon-container {
	transition: background-color 0.22s ease, transform 0.22s ease;
}
.wp-block-kadence-infobox:hover .kadence-info-box-icon-container {
	transform: scale(1.06);
}
/* Title color subtly shifts to accent on hover */
.wp-block-kadence-infobox .kt-blocks-info-box-title {
	transition: color 0.18s ease;
}
.wp-block-kadence-infobox:hover .kt-blocks-info-box-title {
	color: var(--global-palette1, #1f6feb);
}

/* === Home page 6-tile service grid — hover state on the kadence column === */
.kadence-column57_19fc6f-44,
.kadence-column57_41bbc1-e8,
.kadence-column57_79a7bd-33,
.kadence-column57_ae5097-82,
.kadence-column57_bc259a-31,
.kadence-column57_f512ca-bb {
	transition: transform 0.22s ease, background-color 0.22s ease, box-shadow 0.22s ease;
	border-radius: 10px;
	padding: 12px !important;
}
.kadence-column57_19fc6f-44:hover,
.kadence-column57_41bbc1-e8:hover,
.kadence-column57_79a7bd-33:hover,
.kadence-column57_ae5097-82:hover,
.kadence-column57_bc259a-31:hover,
.kadence-column57_f512ca-bb:hover {
	transform: translateY(-3px);
	background: rgba(31, 111, 235, 0.04);
	box-shadow: 0 8px 24px -16px rgba(31, 111, 235, 0.25);
}
.kadence-column57_19fc6f-44 h4,
.kadence-column57_41bbc1-e8 h4,
.kadence-column57_79a7bd-33 h4,
.kadence-column57_ae5097-82 h4,
.kadence-column57_bc259a-31 h4,
.kadence-column57_f512ca-bb h4 {
	transition: color 0.18s ease;
}
.kadence-column57_19fc6f-44:hover h4,
.kadence-column57_41bbc1-e8:hover h4,
.kadence-column57_79a7bd-33:hover h4,
.kadence-column57_ae5097-82:hover h4,
.kadence-column57_bc259a-31:hover h4,
.kadence-column57_f512ca-bb:hover h4 {
	color: var(--global-palette1, #1f6feb) !important;
}

/* === Focus visibility (keyboard accessibility) === */
:focus-visible {
	outline: 2px solid var(--global-palette1, #1f6feb);
	outline-offset: 3px;
	border-radius: 4px;
}
.wp-block-kadence-singlebtn .kb-button:focus-visible,
.wp-block-button__link:focus-visible {
	outline: 2px solid var(--global-palette9, #fff);
	outline-offset: -4px;
	box-shadow: 0 0 0 4px var(--global-palette1, #1f6feb);
}
a:focus:not(:focus-visible) { outline: none; }

/* === Hero refinements: tighter mobile sizing === */
@media (max-width: 768px) {
	.kb-section-dir-vertical h1.kt-adv-heading-wrap,
	.wp-block-kadence-advancedheading h1 {
		font-size: clamp(2rem, 8vw, 3rem) !important;
		line-height: 1.15 !important;
	}
}

/* === Section rhythm — eliminate harsh seams between adjacent same-color rows === */
.wp-block-kadence-rowlayout + .wp-block-kadence-rowlayout {
	position: relative;
}

/* === Navigation — slightly punchier dropdown === */
.site-main-header-wrap .header-menu-container .menu .menu-item-has-children > .sub-menu {
	box-shadow: 0 12px 32px -12px rgba(0, 0, 0, 0.18);
	border-radius: 6px;
	overflow: hidden;
	border: 1px solid rgba(0, 0, 0, 0.04);
}
.site-main-header-wrap .header-menu-container .menu .sub-menu li a {
	transition: background-color 0.15s ease, color 0.15s ease, padding-left 0.18s ease;
}
.site-main-header-wrap .header-menu-container .menu .sub-menu li:hover > a {
	padding-left: calc(var(--menu-item-padding-x, 1em) + 4px);
}

/* === Footer polish === */
.site-footer .site-footer-row-container-inner a {
	transition: opacity 0.15s ease, color 0.15s ease;
}
.site-footer .footer-social-item {
	transition: transform 0.18s ease, background-color 0.18s ease, color 0.18s ease !important;
}
.site-footer .footer-social-item:hover {
	transform: translateY(-2px);
}

/* === Scroll-to-top button polish === */
.kadence-scroll-to-top {
	transition: transform 0.18s ease, opacity 0.18s ease, background-color 0.18s ease !important;
}
.kadence-scroll-to-top:hover {
	transform: translateY(-3px);
}

/* === Forms (Fluent Forms) — softer inputs === */
.fluentform .ff-el-input--content input[type="text"],
.fluentform .ff-el-input--content input[type="email"],
.fluentform .ff-el-input--content input[type="tel"],
.fluentform .ff-el-input--content textarea,
.fluentform .ff-el-input--content select {
	transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.fluentform .ff-el-input--content input:focus,
.fluentform .ff-el-input--content textarea:focus,
.fluentform .ff-el-input--content select:focus {
	border-color: var(--global-palette1, #1f6feb);
	box-shadow: 0 0 0 3px rgba(31, 111, 235, 0.15);
}

/* === Reduced motion respect === */
@media (prefers-reduced-motion: reduce) {
	*, *::before, *::after {
		animation-duration: 0.01ms !important;
		transition-duration: 0.01ms !important;
		scroll-behavior: auto !important;
	}
}

/* === Utility: section dividers — subtle line between palette9 → palette8 transitions === */
.wp-block-kadence-rowlayout[class*="theme-palette8"] + .wp-block-kadence-rowlayout[class*="theme-palette9"],
.wp-block-kadence-rowlayout[class*="theme-palette9"] + .wp-block-kadence-rowlayout[class*="theme-palette8"] {
	border-top: 1px solid rgba(0,0,0,0.03);
}

/* === Card shadow refinement — softer, more believable depth === */
.wp-block-kadence-column[style*="box-shadow"],
.wp-block-kadence-infobox .kt-info-box,
.wp-block-kadence-infobox > div {
	box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 8px 24px -12px rgba(0,0,0,0.08);
}

/* === Image polish — smooth loading + prevent layout shift === */
.wp-block-kadence-image img,
.kb-image img,
.wp-block-image img {
	height: auto;
	max-width: 100%;
	display: block;
}
.wp-block-kadence-image figure {
	overflow: hidden;
	border-radius: 8px;
}
.wp-block-kadence-image img {
	transition: transform 0.4s ease;
}
.wp-block-kadence-image:hover img {
	transform: scale(1.015);
}

/* === Iconlist tightening — better vertical rhythm and arrow color === */
.wp-block-kadence-iconlist .kt-svg-icon-list-item-wrap {
	transition: transform 0.18s ease;
}
.wp-block-kadence-iconlist .kt-svg-icon-list-item-wrap:hover {
	transform: translateX(3px);
}

/* === Headings — better contrast on light backgrounds === */
.wp-block-kadence-advancedheading.has-theme-palette-3-color {
	color: var(--global-palette3, #1a202c) !important;
}

/* === Mobile menu — improve drawer usability === */
@media (max-width: 1024px) {
	.mobile-toggle-open-container .menu-toggle-open {
		transition: background-color 0.2s ease, color 0.2s ease;
	}
	.mobile-toggle-open-container .menu-toggle-open:hover {
		background-color: rgba(0,0,0,0.04);
		border-radius: 6px;
	}
}

/* === Hero readability — drop shadow on text over image overlays === */
.kt-row-layout-overlay + .kt-row-column-wrap .kt-adv-heading-wrap.has-theme-palette-9-color,
.kt-row-layout-overlay + .kt-row-column-wrap h1.has-theme-palette-9-color {
	text-shadow: 0 2px 12px rgba(0,0,0,0.15);
}

/* === Section-anchor scroll offset (so #anchor doesn't hide under sticky header) === */
[id^="step-"], [id^="faq"], [id^="section-"] {
	scroll-margin-top: 100px;
}

/* === Gentle entrance for FAQ items === */
.csuite-faq__item {
	animation: csuite-fade-up 0.45s ease both;
}
.csuite-faq__item:nth-child(1) { animation-delay: 0.05s; }
.csuite-faq__item:nth-child(2) { animation-delay: 0.10s; }
.csuite-faq__item:nth-child(3) { animation-delay: 0.15s; }
.csuite-faq__item:nth-child(4) { animation-delay: 0.20s; }
.csuite-faq__item:nth-child(5) { animation-delay: 0.25s; }
@keyframes csuite-fade-up {
	from { opacity: 0; transform: translateY(8px); }
	to   { opacity: 1; transform: translateY(0); }
}

/* === Better text rendering for the founder bio paragraph === */
.entry-content p strong {
	color: var(--global-palette3, #1a202c);
	font-weight: 700;
}
.entry-content p strong + br + br + strong {
	display: inline-block;
	margin-top: 4px;
}

/* === Footer link consistency === */
.site-footer-row-container-inner a {
	text-decoration: none;
}
.site-footer-row-container-inner a:hover {
	opacity: 0.8;
}

/* === Selection / accessibility small improvements === */
img { -webkit-user-drag: none; }
button, [role="button"] { cursor: pointer; }
</style>
	<?php
}, 100 );
