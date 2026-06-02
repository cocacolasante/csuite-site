<?php
/**
 * Plugin Name: CSuite Code Design System
 * Description: Linear/Vercel-inspired design system - dark hero, light body, gradient accents, conversion-focused components.
 * Version: 2.0.0
 * Author: CSuite Code
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load Inter from Google Fonts with preload, preconnect, and display=swap
// for fast LCP and zero invisible-text flash.
add_action( 'wp_head', function () {
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
	<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"></noscript>
	<?php
}, 5 );

// Image loading hints across the site: lazy + async-decode by default,
// and let the first hero image upgrade to fetchpriority=high (LCP candidate).
add_filter( 'wp_get_attachment_image_attributes', function( $attrs ) {
	if ( ! isset( $attrs['loading'] ) ) $attrs['loading'] = 'lazy';
	if ( ! isset( $attrs['decoding'] ) ) $attrs['decoding'] = 'async';
	return $attrs;
} );

add_action( 'wp_head', function () {
	?>
<style id="csuite-design-system">
:root {
	--c-bg: #ffffff;
	--c-bg-alt: #f7f8fa;
	--c-bg-soft: #f0f2f5;
	--c-fg: #0a0e1a;
	--c-fg-2: #1f2937;
	--c-fg-muted: #4b5563;
	--c-fg-dim: #6b7280;
	--c-border: #e5e7eb;
	--c-border-2: #d1d5db;

	--c-dark: #0a0e1a;
	--c-dark-2: #111827;
	--c-dark-3: #1f2937;
	--c-dark-text: #f9fafb;
	--c-dark-muted: #9ca3af;
	--c-dark-border: rgba(255,255,255,0.08);

	--c-accent: #2563eb;
	--c-accent-2: #7c3aed;
	--c-accent-3: #06b6d4;
	--c-accent-glow: rgba(37, 99, 235, 0.32);

	--c-gradient: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
	--c-gradient-soft: linear-gradient(135deg, rgba(37, 99, 235, 0.10) 0%, rgba(124, 58, 237, 0.10) 100%);
	--c-radial: radial-gradient(80% 60% at 50% 0%, rgba(37, 99, 235, 0.28) 0%, rgba(124, 58, 237, 0.18) 30%, transparent 70%);

	/* Kadence-style palette aliases — map legacy --global-palette* tokens used by
	   newer geo/industry/blog pages onto the canonical design system so every
	   page renders with identical colors. */
	--global-palette1: var(--c-accent);
	--global-palette2: var(--c-accent-2);
	--global-palette3: var(--c-fg);
	--global-palette4: var(--c-fg-muted);
	--global-palette5: var(--c-fg-dim);
	--global-palette6: var(--c-border-2);
	--global-palette7: var(--c-border);
	--global-palette8: var(--c-bg-alt);
	--global-palette9: var(--c-bg);

	--font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;

	--radius-sm: 6px;
	--radius: 10px;
	--radius-lg: 16px;
	--radius-xl: 24px;

	--shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
	--shadow: 0 4px 16px -8px rgba(0,0,0,0.08), 0 1px 3px rgba(0,0,0,0.06);
	--shadow-lg: 0 20px 50px -20px rgba(15, 23, 42, 0.18), 0 8px 20px -12px rgba(15, 23, 42, 0.10);
	--shadow-accent: 0 12px 40px -16px var(--c-accent-glow);

	--section-y: clamp(64px, 9vw, 120px);
}

/* === Base resets === */
html { scroll-behavior: smooth; }
body {
	font-family: var(--font-sans) !important;
	color: var(--c-fg);
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-rendering: optimizeLegibility;
}
::selection { background: var(--c-accent); color: #fff; }

.entry-content :is(h1,h2,h3,h4,h5,h6) {
	font-family: var(--font-sans);
	letter-spacing: -0.02em;
	color: var(--c-fg);
	font-weight: 700;
	line-height: 1.15;
}

/* === Page header tweak - make site nav look more "Linear" === */
.site-main-header-wrap, .site-header-wrap {
	border-bottom: 1px solid var(--c-border);
	background: rgba(255,255,255,0.85) !important;
	backdrop-filter: saturate(180%) blur(10px);
	-webkit-backdrop-filter: saturate(180%) blur(10px);
}
.site-main-header-inner-wrap .header-button .kb-button,
.site-main-header-inner-wrap a.button {
	background: var(--c-fg) !important;
	color: #fff !important;
	border-radius: 999px !important;
	font-weight: 600 !important;
	padding: 0.55em 1.2em !important;
	border: 1px solid var(--c-fg) !important;
	transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease !important;
}
.site-main-header-inner-wrap .header-button .kb-button:hover {
	background: var(--c-dark-2) !important;
	transform: translateY(-1px);
	box-shadow: var(--shadow-accent);
}

/* === Hero (dark) === */
.csuite-hero {
	position: relative;
	background: var(--c-dark);
	color: var(--c-dark-text);
	padding: clamp(80px, 12vw, 160px) 20px clamp(60px, 9vw, 120px);
	overflow: hidden;
	isolation: isolate;
}
.csuite-hero::before {
	content: "";
	position: absolute;
	inset: 0;
	background: var(--c-radial);
	z-index: -1;
}
.csuite-hero::after {
	content: "";
	position: absolute;
	inset: auto 0 -1px;
	height: 1px;
	background: linear-gradient(90deg, transparent, var(--c-accent), transparent);
	opacity: 0.4;
	z-index: -1;
}
.csuite-hero__inner {
	max-width: 1080px;
	margin: 0 auto;
	text-align: center;
}
.csuite-hero__eyebrow {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	padding: 6px 14px;
	background: rgba(255,255,255,0.06);
	border: 1px solid var(--c-dark-border);
	border-radius: 999px;
	font-size: 0.78rem;
	font-weight: 500;
	color: var(--c-dark-text);
	margin-bottom: 28px;
	letter-spacing: 0.02em;
}
.csuite-hero__eyebrow::before {
	content: "";
	display: inline-block;
	width: 6px; height: 6px;
	border-radius: 50%;
	background: var(--c-accent-3);
	box-shadow: 0 0 12px var(--c-accent-3);
}
.csuite-hero__title {
	font-size: clamp(2.25rem, 6vw, 4.25rem);
	font-weight: 800;
	letter-spacing: -0.03em;
	line-height: 1.05;
	margin: 0 0 24px;
	color: var(--c-dark-text);
	background: linear-gradient(180deg, #ffffff 0%, #c9d2e6 100%);
	-webkit-background-clip: text;
	background-clip: text;
	-webkit-text-fill-color: transparent;
}
.csuite-hero__title em {
	font-style: normal;
	background: var(--c-gradient);
	-webkit-background-clip: text;
	background-clip: text;
	-webkit-text-fill-color: transparent;
}
.csuite-hero__sub {
	font-size: clamp(1.05rem, 1.6vw, 1.25rem);
	line-height: 1.6;
	color: var(--c-dark-muted);
	max-width: 720px;
	margin: 0 auto 36px;
}
.csuite-hero__cta {
	display: flex;
	gap: 12px;
	justify-content: center;
	flex-wrap: wrap;
	margin-bottom: 28px;
}
.csuite-hero__trust {
	color: var(--c-dark-muted);
	font-size: 0.85rem;
	display: flex;
	gap: 16px;
	justify-content: center;
	flex-wrap: wrap;
	margin-top: 16px;
}
.csuite-hero__trust span { display: inline-flex; align-items: center; gap: 6px; }
.csuite-hero__trust svg { width: 16px; height: 16px; color: var(--c-accent-3); flex-shrink: 0; }

/* === Buttons === */
.csuite-btn {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	padding: 14px 26px;
	font-weight: 600;
	font-size: 0.98rem;
	border-radius: 999px;
	text-decoration: none !important;
	transition: transform 0.15s ease, box-shadow 0.18s ease, background 0.18s ease, color 0.18s ease, border-color 0.18s ease;
	cursor: pointer;
	border: 1px solid transparent;
	white-space: nowrap;
	line-height: 1;
}
.csuite-btn:hover { transform: translateY(-1px); }
.csuite-btn--primary {
	background: var(--c-gradient);
	color: #fff !important;
	box-shadow: 0 8px 24px -10px var(--c-accent-glow);
}
.csuite-btn--primary:hover {
	box-shadow: 0 12px 36px -10px var(--c-accent-glow), 0 0 0 4px rgba(37,99,235,0.12);
}
.csuite-btn--ghost {
	background: rgba(255,255,255,0.04);
	color: var(--c-dark-text) !important;
	border-color: var(--c-dark-border);
	backdrop-filter: blur(6px);
}
.csuite-btn--ghost:hover {
	background: rgba(255,255,255,0.08);
	border-color: rgba(255,255,255,0.2);
}
.csuite-btn--dark {
	background: var(--c-fg);
	color: #fff !important;
}
.csuite-btn--dark:hover {
	background: var(--c-dark-2);
	box-shadow: var(--shadow-accent);
}
.csuite-btn--outline {
	background: transparent;
	color: var(--c-fg) !important;
	border-color: var(--c-border-2);
}
.csuite-btn--outline:hover {
	border-color: var(--c-fg);
	background: var(--c-bg-alt);
}
.csuite-btn::after {
	content: "→";
	transition: transform 0.18s ease;
}
.csuite-btn:hover::after { transform: translateX(3px); }
.csuite-btn--no-arrow::after { display: none; }

/* === Tools strip (was "trusted by") === */
.csuite-tools {
	background: var(--c-bg);
	padding: 44px 20px 28px;
	border-bottom: 1px solid var(--c-border);
}
.csuite-tools__inner { max-width: 1080px; margin: 0 auto; text-align: center; }
.csuite-tools__label {
	font-size: 0.78rem;
	letter-spacing: 0.18em;
	text-transform: uppercase;
	font-weight: 600;
	color: var(--c-fg-dim);
	margin: 0 0 24px;
}
.csuite-tools__row {
	display: flex;
	flex-wrap: wrap;
	gap: 28px 48px;
	justify-content: center;
	align-items: center;
}
.csuite-tools__row img {
	height: 36px;
	width: auto;
	max-width: 140px;
	opacity: 0.55;
	filter: grayscale(100%);
	transition: opacity 0.18s ease, filter 0.18s ease;
}
.csuite-tools__row img:hover { opacity: 1; filter: grayscale(0%); }

/* === Generic section === */
.csuite-section {
	background: var(--c-bg);
	padding: var(--section-y) 20px;
}
.csuite-section--alt { background: var(--c-bg-alt); }
.csuite-section--dark { background: var(--c-dark); color: var(--c-dark-text); }
.csuite-section--dark :is(h1,h2,h3,h4,h5,h6) { color: var(--c-dark-text); }
.csuite-section__inner { max-width: 1140px; margin: 0 auto; }

.csuite-eyebrow {
	display: inline-block;
	font-size: 0.78rem;
	letter-spacing: 0.16em;
	text-transform: uppercase;
	font-weight: 600;
	color: var(--c-accent);
	margin: 0 0 14px;
}
.csuite-section--dark .csuite-eyebrow { color: var(--c-accent-3); }
.csuite-h2 {
	font-size: clamp(1.85rem, 3.4vw, 2.75rem);
	font-weight: 800;
	letter-spacing: -0.025em;
	line-height: 1.1;
	margin: 0 0 18px;
}
.csuite-lede {
	font-size: clamp(1.05rem, 1.4vw, 1.2rem);
	line-height: 1.6;
	color: var(--c-fg-muted);
	max-width: 720px;
	margin: 0 0 48px;
}
.csuite-section--dark .csuite-lede { color: var(--c-dark-muted); }
.csuite-section--center { text-align: center; }
.csuite-section--center .csuite-lede { margin-left: auto; margin-right: auto; }

/* === Cards === */
.csuite-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
	gap: 20px;
}
.csuite-grid--3 { grid-template-columns: repeat(3, 1fr); }
.csuite-grid--4 { grid-template-columns: repeat(4, 1fr); }
@media (max-width: 900px) {
	.csuite-grid--3, .csuite-grid--4 { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
	.csuite-grid--3, .csuite-grid--4 { grid-template-columns: 1fr; }
}

.csuite-card {
	background: var(--c-bg);
	border: 1px solid var(--c-border);
	border-radius: var(--radius-lg);
	padding: 28px;
	transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
	display: flex;
	flex-direction: column;
	gap: 12px;
	position: relative;
	overflow: hidden;
}
.csuite-card:hover {
	transform: translateY(-3px);
	box-shadow: var(--shadow-lg);
	border-color: var(--c-accent);
}
.csuite-card__icon {
	width: 44px; height: 44px;
	border-radius: 12px;
	display: flex;
	align-items: center;
	justify-content: center;
	background: var(--c-gradient-soft);
	color: var(--c-accent);
	font-size: 1.4rem;
}
.csuite-card__title {
	font-size: 1.15rem;
	font-weight: 700;
	color: var(--c-fg);
	margin: 0;
}
.csuite-card__body {
	color: var(--c-fg-muted);
	line-height: 1.55;
	font-size: 0.97rem;
	margin: 0;
}
.csuite-card__link {
	font-weight: 600;
	font-size: 0.92rem;
	color: var(--c-accent);
	text-decoration: none !important;
	display: inline-flex;
	gap: 4px;
	align-items: center;
	margin-top: 4px;
}
.csuite-card__link::after { content: "→"; transition: transform 0.15s ease; }
.csuite-card__link:hover::after { transform: translateX(3px); }

/* Dark card variant for dark sections */
.csuite-section--dark .csuite-card {
	background: var(--c-dark-2);
	border-color: var(--c-dark-border);
	color: var(--c-dark-text);
}
.csuite-section--dark .csuite-card__title { color: var(--c-dark-text); }
.csuite-section--dark .csuite-card__body { color: var(--c-dark-muted); }
.csuite-section--dark .csuite-card:hover { border-color: var(--c-accent); }

/* === Number list / process === */
.csuite-steps { counter-reset: step; }
.csuite-step {
	background: var(--c-bg);
	border: 1px solid var(--c-border);
	border-radius: var(--radius-lg);
	padding: 28px;
	display: flex;
	flex-direction: column;
	gap: 10px;
	position: relative;
}
.csuite-step::before {
	counter-increment: step;
	content: "0" counter(step);
	font-size: 0.85rem;
	font-weight: 700;
	color: var(--c-accent);
	letter-spacing: 0.06em;
}
.csuite-step h3 { font-size: 1.15rem; margin: 0; }
.csuite-step p { color: var(--c-fg-muted); line-height: 1.55; margin: 0; font-size: 0.97rem; }

/* === Founder credibility band === */
.csuite-founder {
	background: var(--c-bg-alt);
	padding: 60px 20px;
	border-block: 1px solid var(--c-border);
}
.csuite-founder__inner {
	max-width: 880px;
	margin: 0 auto;
	display: flex;
	gap: 28px;
	align-items: center;
}
.csuite-founder__photo {
	width: 92px;
	height: 92px;
	border-radius: 50%;
	object-fit: cover;
	flex-shrink: 0;
	box-shadow: var(--shadow);
	border: 3px solid #fff;
}
.csuite-founder__quote { font-size: 1.05rem; line-height: 1.6; color: var(--c-fg-2); margin: 0 0 12px; }
.csuite-founder__name {
	font-weight: 700;
	color: var(--c-fg);
	display: inline;
}
.csuite-founder__name + .csuite-founder__role {
	color: var(--c-fg-dim);
	font-size: 0.92rem;
	margin-left: 6px;
}
@media (max-width: 600px) {
	.csuite-founder__inner { flex-direction: column; text-align: center; gap: 18px; }
}

/* === Big CTA band === */
.csuite-cta-band {
	background: var(--c-dark);
	color: var(--c-dark-text);
	padding: clamp(60px, 8vw, 100px) 20px;
	position: relative;
	overflow: hidden;
	isolation: isolate;
}
.csuite-cta-band::before {
	content: "";
	position: absolute; inset: 0;
	background: var(--c-radial);
	z-index: -1;
	opacity: 0.7;
}
.csuite-cta-band__inner {
	max-width: 820px;
	margin: 0 auto;
	text-align: center;
}
.csuite-cta-band h2 {
	font-size: clamp(2rem, 4vw, 3rem);
	margin: 0 0 18px;
	color: var(--c-dark-text);
	letter-spacing: -0.025em;
	font-weight: 800;
}
.csuite-cta-band p {
	font-size: 1.1rem;
	color: var(--c-dark-muted);
	margin: 0 0 32px;
	line-height: 1.55;
}
.csuite-cta-band .csuite-btn--ghost { color: var(--c-dark-text) !important; }

/* === Stats row === */
.csuite-stats {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
	gap: 28px;
}
.csuite-stat__num {
	font-size: clamp(2rem, 4vw, 3rem);
	font-weight: 800;
	letter-spacing: -0.03em;
	background: var(--c-gradient);
	-webkit-background-clip: text;
	background-clip: text;
	-webkit-text-fill-color: transparent;
	line-height: 1;
}
.csuite-stat__label {
	font-size: 0.92rem;
	color: var(--c-fg-muted);
	margin-top: 6px;
}
.csuite-section--dark .csuite-stat__label { color: var(--c-dark-muted); }

/* === Pricing cards === */
.csuite-tier {
	background: var(--c-bg);
	border: 1px solid var(--c-border);
	border-radius: var(--radius-lg);
	padding: 36px 28px;
	display: flex;
	flex-direction: column;
	gap: 16px;
	transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
	position: relative;
}
.csuite-tier:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: var(--c-accent); }
.csuite-tier--featured {
	background: var(--c-dark);
	color: var(--c-dark-text);
	border-color: var(--c-dark);
	box-shadow: var(--shadow-lg);
}
.csuite-tier--featured h3, .csuite-tier--featured .csuite-tier__price { color: var(--c-dark-text); }
.csuite-tier--featured .csuite-tier__sub, .csuite-tier--featured li { color: var(--c-dark-muted); }
.csuite-tier__badge {
	position: absolute;
	top: -12px; left: 50%;
	transform: translateX(-50%);
	background: var(--c-gradient);
	color: #fff;
	padding: 6px 14px;
	border-radius: 999px;
	font-size: 0.72rem;
	letter-spacing: 0.06em;
	font-weight: 700;
	text-transform: uppercase;
	box-shadow: var(--shadow-accent);
}
.csuite-tier h3 { font-size: 1.4rem; margin: 0; font-weight: 700; }
.csuite-tier__price { font-size: 2.5rem; font-weight: 800; color: var(--c-fg); letter-spacing: -0.02em; }
.csuite-tier__price small { font-size: 0.92rem; color: var(--c-fg-dim); font-weight: 500; }
.csuite-tier--featured .csuite-tier__price small { color: var(--c-dark-muted); }
.csuite-tier__sub { color: var(--c-fg-muted); font-size: 0.95rem; line-height: 1.5; margin: 0 0 8px; }
.csuite-tier ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
.csuite-tier li {
	position: relative; padding-left: 24px;
	color: var(--c-fg-muted); line-height: 1.5; font-size: 0.95rem;
}
.csuite-tier li::before {
	content: ""; position: absolute; left: 0; top: 7px;
	width: 16px; height: 16px;
	background: var(--c-accent);
	-webkit-mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E") center/contain no-repeat;
	mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E") center/contain no-repeat;
}
.csuite-tier--featured li::before { background: var(--c-accent-3); }
.csuite-tier .csuite-btn { margin-top: auto; justify-content: center; }

/* === Page intro band (for non-home pages with smaller hero) === */
.csuite-pagehero {
	background: var(--c-dark);
	color: var(--c-dark-text);
	padding: clamp(80px, 10vw, 140px) 20px clamp(50px, 7vw, 90px);
	text-align: center;
	position: relative;
	overflow: hidden;
	isolation: isolate;
}
.csuite-pagehero::before {
	content: ""; position: absolute; inset: 0;
	background: var(--c-radial);
	opacity: 0.7;
	z-index: -1;
}
.csuite-pagehero__inner { max-width: 880px; margin: 0 auto; }
.csuite-pagehero__eyebrow {
	display: inline-block;
	font-size: 0.78rem;
	letter-spacing: 0.18em;
	text-transform: uppercase;
	font-weight: 600;
	color: var(--c-accent-3);
	margin: 0 0 14px;
}
.csuite-pagehero h1 {
	font-size: clamp(2.25rem, 5vw, 3.5rem);
	margin: 0 0 18px;
	color: var(--c-dark-text);
	letter-spacing: -0.03em;
	line-height: 1.1;
	font-weight: 800;
}
.csuite-pagehero p {
	font-size: clamp(1.05rem, 1.5vw, 1.2rem);
	color: var(--c-dark-muted);
	line-height: 1.6;
	margin: 0 0 28px;
	max-width: 680px;
	margin-left: auto;
	margin-right: auto;
}
.csuite-pagehero__cta { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

/* === Sticky CTA bar (always reachable) === */
.csuite-stickybar {
	position: fixed;
	right: 20px;
	bottom: 20px;
	z-index: 9990;
	display: flex;
	gap: 10px;
	align-items: center;
}
.csuite-stickybar .csuite-btn { box-shadow: 0 8px 24px -8px var(--c-accent-glow); }
.csuite-stickybar .csuite-stickybar__call {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	background: var(--c-bg);
	color: var(--c-fg);
	border: 1px solid var(--c-border-2);
	border-radius: 999px;
	padding: 12px 20px;
	font-weight: 700;
	font-size: 0.95rem;
	text-decoration: none;
	box-shadow: var(--shadow);
	transition: border-color 0.15s ease, transform 0.15s ease;
}
.csuite-stickybar .csuite-stickybar__call:hover { border-color: var(--c-accent); transform: translateY(-2px); }
@media (max-width: 768px) {
	.csuite-stickybar { left: 12px; right: 12px; bottom: 12px; justify-content: center; }
	.csuite-stickybar .csuite-btn, .csuite-stickybar .csuite-stickybar__call { flex: 1; justify-content: center; text-align: center; }
}

/* === FAQ override to align with design system === */
.csuite-faq { background: var(--c-bg-alt); padding: var(--section-y) 20px; }
.csuite-faq__inner { max-width: 760px; }
.csuite-faq__title { font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; letter-spacing: -0.025em; color: var(--c-fg); }
.csuite-faq__item {
	background: var(--c-bg);
	border: 1px solid var(--c-border);
	border-radius: var(--radius);
	padding: 22px 26px;
}
.csuite-faq__item[open] { border-color: var(--c-accent); box-shadow: var(--shadow); }
.csuite-faq__q { color: var(--c-fg); }
.csuite-faq__q::after { color: var(--c-accent); }
.csuite-faq__a { color: var(--c-fg-muted); }

/* === Related services override === */
.csuite-related { background: var(--c-bg); border-top: 1px solid var(--c-border); padding: var(--section-y) 20px; }
.csuite-related__title { font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; letter-spacing: -0.025em; }
.csuite-related__card { border-radius: var(--radius-lg); padding: 26px; transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease; }
.csuite-related__card:hover { box-shadow: var(--shadow-lg); transform: translateY(-3px); border-color: var(--c-accent); }
.csuite-related__label { font-weight: 700; color: var(--c-fg); }
.csuite-related__card:hover .csuite-related__label { color: var(--c-accent); }
.csuite-related__desc { color: var(--c-fg-muted); }
.csuite-related__arrow { color: var(--c-accent); }

/* === Comparison / pricing tables (promoted from per-page inline styles) === */
.csuite-table-wrap { max-width: 920px; margin: 0 auto; overflow-x: auto; }
.csuite-table {
	width: 100%;
	border-collapse: collapse;
	background: var(--c-bg);
	border: 1px solid var(--c-border);
	border-radius: var(--radius);
	overflow: hidden;
	font-size: 0.97rem;
}
.csuite-table th, .csuite-table td {
	padding: 14px 18px;
	text-align: left;
	border-bottom: 1px solid var(--c-border);
}
.csuite-table thead th {
	background: var(--c-dark);
	color: var(--c-dark-text);
	font-weight: 700;
	font-size: 0.9rem;
	letter-spacing: 0.01em;
}
.csuite-table tbody tr:last-child td { border-bottom: none; }
.csuite-table tbody tr:nth-child(even) { background: var(--c-bg-alt); }

/* === Blog post typography (promoted from per-post inline styles) === */
.csuite-post { max-width: 780px; margin: 0 auto; font-size: 1.06rem; line-height: 1.7; color: var(--c-fg-muted); }
.csuite-post h2 { font-size: clamp(1.35rem, 2.2vw, 1.7rem); font-weight: 700; color: var(--c-fg); margin: 2em 0 0.6em; letter-spacing: -0.01em; }
.csuite-post h3 { font-size: 1.15rem; font-weight: 700; color: var(--c-fg); margin: 1.5em 0 0.4em; }
.csuite-post__byline { color: var(--c-fg-dim); font-size: 0.95rem; margin-bottom: 1.5em; }
.csuite-post__lede { font-size: 1.2rem; line-height: 1.6; color: var(--c-fg); }
.csuite-post ol { padding-left: 1.3em; } .csuite-post li { margin: 0.5em 0; }
.csuite-post__cta { margin: 2.5em 0 1em; }

/* === Lead-capture form (Fluent Forms, styled to design system) === */
.csuite-formwrap { max-width: 640px; margin: 0 auto; }
.csuite-form-card {
	background: var(--c-bg);
	border: 1px solid var(--c-border);
	border-radius: var(--radius-lg);
	padding: 36px;
	box-shadow: var(--shadow);
}
.csuite-formwrap .fluentform .ff-el-input--label label,
.csuite-formwrap .fluentform label { font-weight: 600; color: var(--c-fg); font-size: 0.92rem; }
.csuite-formwrap .fluentform input[type=text],
.csuite-formwrap .fluentform input[type=email],
.csuite-formwrap .fluentform input[type=tel],
.csuite-formwrap .fluentform textarea,
.csuite-formwrap .fluentform select {
	width: 100%;
	border: 1px solid var(--c-border-2);
	border-radius: var(--radius);
	padding: 12px 14px;
	font-family: var(--font-sans);
	font-size: 1rem;
	color: var(--c-fg);
	background: var(--c-bg);
	transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.csuite-formwrap .fluentform input:focus,
.csuite-formwrap .fluentform textarea:focus,
.csuite-formwrap .fluentform select:focus {
	outline: none;
	border-color: var(--c-accent);
	box-shadow: 0 0 0 3px var(--c-accent-glow);
}
.csuite-formwrap .fluentform .ff-btn-submit,
.csuite-formwrap .fluentform button[type=submit] {
	background: var(--c-gradient);
	color: #fff;
	border: none;
	border-radius: 999px;
	padding: 14px 28px;
	font-weight: 700;
	font-size: 1rem;
	cursor: pointer;
	box-shadow: var(--shadow-accent);
	transition: transform 0.15s ease;
}
.csuite-formwrap .fluentform .ff-btn-submit:hover { transform: translateY(-2px); }

/* === Distraction-free landing pages (Google Ads) ===
   Pages 428 thank-you, 429 generic LP, 430 nonprofit LP: hide header, footer,
   and sticky bar so the only action is the form. */
.page-id-428 #masthead, .page-id-428 #colophon, .page-id-428 .csuite-stickybar,
.page-id-429 #masthead, .page-id-429 #colophon, .page-id-429 .csuite-stickybar,
.page-id-430 #masthead, .page-id-430 #colophon, .page-id-430 .csuite-stickybar {
	display: none !important;
}
.page-id-428 .site-content, .page-id-428 .content-area,
.page-id-429 .site-content, .page-id-429 .content-area,
.page-id-430 .site-content, .page-id-430 .content-area {
	padding-top: 0 !important; padding-bottom: 0 !important; margin-top: 0 !important; margin-bottom: 0 !important;
}
.page-id-428 .entry-content, .page-id-429 .entry-content, .page-id-430 .entry-content { margin: 0 !important; }

/* === Hide leftover legacy/demo stuff if it sneaks back in === */
.entry-content [class*="placeholder-image"] { display: none; }

/* === Mobile responsiveness === */
@media (max-width: 600px) {
	.csuite-hero { padding: 80px 16px 60px; }
	.csuite-section { padding: 60px 16px; }
	.csuite-pagehero { padding: 80px 16px 50px; }
	.csuite-founder__inner { padding: 0 16px; }
}

/* === Prevent FOUC for Inter === */
.wp-block-kadence-advancedheading,
.wp-block-kadence-rowlayout,
.entry-content p,
.entry-content li {
	font-family: var(--font-sans);
}

/* === Reduced motion === */
@media (prefers-reduced-motion: reduce) {
	*, *::before, *::after { transition-duration: 0.01ms !important; scroll-behavior: auto !important; }
}
</style>
	<?php
}, 100 );

/**
 * Render a global sticky CTA bar at the bottom of every front-end page -
 * call + book-a-call, reachable on desktop and mobile.
 */
add_action( 'wp_footer', function () {
	if ( is_admin() ) return;
	?>
	<div class="csuite-stickybar">
		<a class="csuite-stickybar__call" href="tel:+12675664622">&#9742; (267) 566-4622</a>
		<a class="csuite-btn csuite-btn--primary" href="https://calendar.app.google/jSHYj7c6WtJGykGQ7" target="_blank" rel="noopener">Book a call</a>
	</div>
	<?php
} );
