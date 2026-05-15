<?php
/**
 * Plugin Name: CSuite Code Schema Enhancements
 * Description: Enriches Organization schema, adds Service & FAQ schema, and renders FAQ blocks via shortcode.
 * Version: 1.1.0
 * Author: CSuite Code
 */

if ( ! defined( 'ABSPATH' ) ) exit;

const CSUITE_ORG_ID    = 'https://csuitecode.com/#organization';
const CSUITE_LINKEDIN  = 'https://www.linkedin.com/company/c-suite-code/';
const CSUITE_GRANTMIND = 'https://grantmind.pro/';

/**
 * FAQ definitions per page ID. Single source of truth — used for both visible
 * content (via the [csuite_faq] shortcode) and JSON-LD output.
 */
function csuite_faqs_for_page( $post_id ) {
	$faqs = [
		// Home (57)
		57 => [
			[ 'q' => 'What does CSuite Code do?',
			  'a' => 'CSuite Code is a technology consulting firm helping small and medium-sized businesses and nonprofits with websites, IT support, AI automation, managed cloud, and fractional CTO services. We work as a long-term tech partner, not a one-off project shop.' ],
			[ 'q' => 'Who do you typically work with?',
			  'a' => 'Primarily small businesses, home service companies (HVAC, plumbing, cleaning), and verified 501(c)(3) nonprofits across the United States. Our pricing and approach are built around lean teams with limited internal IT staff.' ],
			[ 'q' => 'How does an engagement start?',
			  'a' => 'With a free 30-minute discovery call. We learn about your current tools and where things break down, then send a tailored roadmap and a transparent quote. No pitch decks, no enterprise upsell.' ],
			[ 'q' => 'Are you on-site or remote?',
			  'a' => 'We work remotely with clients across the United States. Most projects do not require on-site visits; for those that do, travel is scoped into the engagement up front.' ],
			[ 'q' => 'How do you bill for your work?',
			  'a' => 'We use a mix of fixed-fee project quotes, hourly consulting, and predictable monthly care packages — whichever fits your budget and risk tolerance best.' ],
		],

		// Services (59)
		59 => [
			[ 'q' => 'What services does CSuite Code offer?',
			  'a' => 'We cover websites and web applications, IT support, AI integration and automation, managed cloud services and migrations, and fractional CTO leadership. All services are sized for small businesses and nonprofits.' ],
			[ 'q' => 'Can CSuite Code handle a project end-to-end?',
			  'a' => 'Yes — we design, build, deploy, train your team, and maintain the system. You do not need to coordinate multiple vendors. We can also slot in alongside your existing IT staff or developers when that makes sense.' ],
			[ 'q' => 'Do you offer ongoing support after a project ships?',
			  'a' => 'Yes. Most clients move into a fixed-fee monthly care plan covering hosting, security updates, monitoring, and a set number of consulting hours each month.' ],
			[ 'q' => 'How quickly can you start?',
			  'a' => 'Discovery calls happen within a few business days. Most projects start within two weeks of a signed engagement.' ],
		],

		// Cloud Solutions (189)
		189 => [
			[ 'q' => 'Which cloud providers do you support?',
			  'a' => 'AWS, Microsoft Azure, Google Cloud, DigitalOcean, and several S3-compatible alternatives. We help you pick the right mix based on workload, cost, and compliance needs.' ],
			[ 'q' => 'Will migrating to a new cloud cause downtime?',
			  'a' => 'For most workloads, no. We use blue-green deployments, replication, and DNS cutover techniques so your team keeps working while data moves in the background.' ],
			[ 'q' => 'How much can I save by migrating off AWS S3?',
			  'a' => 'Most clients save 25 to 40 percent on storage costs by switching to S3-compatible alternatives — without changing the applications that use them.' ],
			[ 'q' => 'Do you handle backups and disaster recovery?',
			  'a' => 'Yes. We set up automated, encrypted backups with off-site replication and document a tested recovery process so you know exactly what happens if something goes wrong.' ],
		],

		// AI for Your Business (162)
		162 => [
			[ 'q' => 'Is my business big enough to benefit from AI?',
			  'a' => 'If your team handles repetitive tasks — email triage, document review, customer follow-ups, scheduling, data entry — AI can give hours back every week. Most of our AI clients have between 5 and 50 employees.' ],
			[ 'q' => 'Will AI replace my employees?',
			  'a' => 'We do not recommend AI projects aimed at replacing people. Our work focuses on freeing your team from repetitive busywork so they can spend more time on the parts of the job that need a human.' ],
			[ 'q' => 'What does an AI integration project look like?',
			  'a' => 'We start with a workflow audit to understand where your team spends time, pick one high-leverage automation, build and test it, then expand. First wins typically ship in two to four weeks.' ],
			[ 'q' => 'How much does AI integration cost?',
			  'a' => 'Scope varies widely. A focused automation pilot generally lands between $5,000 and $15,000; ongoing AI infrastructure is then folded into a monthly care package.' ],
		],

		// Nonprofits (288)
		288 => [
			[ 'q' => 'What discount do nonprofits receive?',
			  'a' => 'Verified 501(c)(3) organizations receive discounted hourly and project rates. Smaller organizations (annual budget under $500,000) qualify for our deepest discount tier.' ],
			[ 'q' => 'What is GrantMind Pro and is it really included?',
			  'a' => 'GrantMind Pro is our AI-powered grant research and proposal-writing platform — normally a $249 per month subscription. While you are an active CSuite Code nonprofit client, your team\'s access is included at no additional cost.' ],
			[ 'q' => 'Does CSuite Code write grant proposals on our behalf?',
			  'a' => 'Through GrantMind Pro, your team gets AI-assisted drafting across the nine standard proposal sections, plus pre-submission scoring. We do not write proposals for you, but we make it dramatically faster for your team to do. If you would rather have a professional work with you one-on-one, we partner with <a href="https://npograntwriting.com" target="_blank" rel="noopener">NPO Grant Writing</a> — they can work with your organization on retainer.' ],
			[ 'q' => 'What kinds of nonprofits typically work with you?',
			  'a' => 'Community-based 501(c)(3) organizations, schools, and small foundations across the United States. We are best suited to organizations that need a long-term tech partner, not a one-off project.' ],
			[ 'q' => 'How do you verify 501(c)(3) status to qualify for the discount?',
			  'a' => 'We ask for your IRS determination letter or your EIN to confirm 501(c)(3) status. Once verified, the discount applies to all engagements.' ],
		],
	];

	$post_id = (int) $post_id;
	return $faqs[ $post_id ] ?? null;
}

/**
 * Related services per page ID — appended after content via the_content filter.
 */
function csuite_related_links_for_page( $post_id ) {
	$related = [
		// Cloud Solutions
		189 => [
			'heading' => 'Related services',
			'links'   => [
				[ 'url' => '/ai/',         'label' => 'AI integration for small businesses',  'desc' => 'Automation and chatbots, sized for lean teams.' ],
				[ 'url' => '/nonprofits/', 'label' => 'Nonprofits',                            'desc' => 'Discounted cloud rates plus complimentary GrantMind Pro access.' ],
			],
		],
		// AI for Your Business
		162 => [
			'heading' => 'Related services',
			'links'   => [
				[ 'url' => '/services-ai-automation/', 'label' => 'AI for home service businesses', 'desc' => 'Scheduling, invoicing, and follow-up automation for HVAC, plumbing, and cleaning teams.' ],
				[ 'url' => '/managed-cloud/',          'label' => 'Managed cloud services',         'desc' => 'Where your AI workloads run, monitored and right-sized.' ],
				[ 'url' => '/nonprofits/',             'label' => 'Nonprofits',                     'desc' => 'Discounted AI engagements for verified 501(c)(3) organizations.' ],
			],
		],
		// Home Services AI Automation
		225 => [
			'heading' => 'Related services',
			'links'   => [
				[ 'url' => '/ai/',       'label' => 'AI integration for small businesses', 'desc' => 'Broader AI consulting beyond home services workflows.' ],
				[ 'url' => '/services/', 'label' => 'All CSuite Code services',             'desc' => 'Web development, IT support, cloud, and fractional CTO work.' ],
			],
		],
		// Nonprofits
		288 => [
			'heading' => 'Related services',
			'links'   => [
				[ 'url' => '/ai/',            'label' => 'AI integration',          'desc' => 'Practical automation for lean nonprofit teams.' ],
				[ 'url' => '/managed-cloud/', 'label' => 'Managed cloud services',  'desc' => 'Hosting, backups, and migration with nonprofit pricing.' ],
			],
		],
		// Pricing
		61 => [
			'heading' => 'Service details',
			'links'   => [
				[ 'url' => '/services/',    'label' => 'See all services',           'desc' => 'Web, IT, AI, cloud, and fractional CTO offerings.' ],
				[ 'url' => '/nonprofits/',  'label' => 'Nonprofit pricing',          'desc' => 'Discounted rates and free GrantMind Pro for verified 501(c)(3) orgs.' ],
			],
		],
		// Services hub
		59 => [
			'heading' => 'Specialized engagements',
			'links'   => [
				[ 'url' => '/nonprofits/',             'label' => 'For nonprofits',                'desc' => 'Discounted rates and complimentary GrantMind Pro access.' ],
				[ 'url' => '/services-ai-automation/', 'label' => 'For home service businesses',   'desc' => 'AI automation built for HVAC, plumbing, and cleaning teams.' ],
			],
		],
	];

	$post_id = (int) $post_id;
	return $related[ $post_id ] ?? null;
}

/**
 * Append the related-services block right before the FAQ section on each
 * service page so it shows up between body content and the FAQ accordion.
 */
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'page' ) || ! in_the_loop() || ! is_main_query() ) return $content;
	$post_id = get_queried_object_id();
	$related = csuite_related_links_for_page( $post_id );
	if ( ! $related ) return $content;

	ob_start();
	?>
	<section class="csuite-related" aria-label="Related services">
		<div class="csuite-related__inner">
			<h2 class="csuite-related__title"><?php echo esc_html( $related['heading'] ); ?></h2>
			<div class="csuite-related__grid">
				<?php foreach ( $related['links'] as $link ) : ?>
					<a class="csuite-related__card" href="<?php echo esc_url( $link['url'] ); ?>">
						<span class="csuite-related__label"><?php echo esc_html( $link['label'] ); ?></span>
						<span class="csuite-related__desc"><?php echo esc_html( $link['desc'] ); ?></span>
						<span class="csuite-related__arrow" aria-hidden="true">→</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	$block = ob_get_clean();

	// Insert before the FAQ section if present, otherwise append.
	if ( strpos( $content, 'csuite-faq' ) !== false ) {
		return preg_replace( '#(<section class="csuite-faq")#', $block . '$1', $content, 1 );
	}
	return $content . $block;
} );

/**
 * Inline CSS for the related-services block.
 */
add_action( 'wp_head', function () {
	if ( ! is_singular( 'page' ) ) return;
	if ( ! csuite_related_links_for_page( get_queried_object_id() ) ) return;
	?>
	<style id="csuite-related-css">
	.csuite-related{background:var(--global-palette8,#f7fafc);padding:60px 20px;border-top:1px solid rgba(0,0,0,0.04)}
	.csuite-related__inner{max-width:1140px;margin:0 auto}
	.csuite-related__title{text-align:center;font-size:clamp(1.5rem,2.2vw,2rem);font-weight:700;color:var(--global-palette3,#1a202c);margin:0 0 28px}
	.csuite-related__grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px}
	.csuite-related__card{display:flex;flex-direction:column;justify-content:space-between;gap:8px;background:var(--global-palette9,#fff);border:1px solid var(--global-palette7,#e6eaef);border-radius:10px;padding:22px 24px;text-decoration:none !important;transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease;position:relative}
	.csuite-related__card:hover{transform:translateY(-3px);border-color:var(--global-palette1,#1f6feb);box-shadow:0 12px 28px -16px rgba(31,111,235,.25)}
	.csuite-related__label{font-weight:700;font-size:1.05rem;color:var(--global-palette3,#1a202c);transition:color .15s ease}
	.csuite-related__card:hover .csuite-related__label{color:var(--global-palette1,#1f6feb)}
	.csuite-related__desc{color:var(--global-palette4,#44525e);font-size:0.95rem;line-height:1.5;flex:1}
	.csuite-related__arrow{align-self:flex-end;color:var(--global-palette1,#1f6feb);font-size:1.25rem;transition:transform .2s ease}
	.csuite-related__card:hover .csuite-related__arrow{transform:translateX(4px)}
	@media(max-width:600px){.csuite-related{padding:40px 16px}.csuite-related__card{padding:18px 20px}}
	</style>
	<?php
} );

/**
 * Render shortcode — visible FAQ section on the page.
 */
add_shortcode( 'csuite_faq', function ( $atts ) {
	$atts = shortcode_atts( [ 'title' => 'Frequently asked questions' ], $atts );

	$post_id = get_queried_object_id();
	$faqs = csuite_faqs_for_page( $post_id );
	if ( empty( $faqs ) ) return '';

	ob_start();
	?>
	<section class="csuite-faq" itemscope itemtype="https://schema.org/FAQPage">
		<div class="csuite-faq__inner">
			<h2 class="csuite-faq__title"><?php echo esc_html( $atts['title'] ); ?></h2>
			<div class="csuite-faq__list">
				<?php foreach ( $faqs as $i => $faq ) : ?>
					<details class="csuite-faq__item" itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"<?php echo $i === 0 ? ' open' : ''; ?>>
						<summary class="csuite-faq__q" itemprop="name"><?php echo esc_html( $faq['q'] ); ?></summary>
						<div class="csuite-faq__a" itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">
							<div itemprop="text"><?php echo wp_kses_post( wpautop( $faq['a'] ) ); ?></div>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
} );

/**
 * Inline CSS for the FAQ section, matching Kadence palette tokens.
 */
add_action( 'wp_head', function () {
	if ( ! is_singular( 'page' ) ) return;
	if ( ! csuite_faqs_for_page( get_queried_object_id() ) ) return;
	?>
	<style id="csuite-faq-css">
	.csuite-faq{background:var(--global-palette9,#fff);padding:60px 20px}
	.csuite-faq__inner{max-width:820px;margin:0 auto}
	.csuite-faq__title{text-align:center;font-size:clamp(1.75rem,2.5vw,2.25rem);font-weight:700;color:var(--global-palette3,#222);margin:0 0 32px}
	.csuite-faq__list{display:flex;flex-direction:column;gap:14px}
	.csuite-faq__item{background:var(--global-palette8,#f7fafc);border:1px solid var(--global-palette7,#e6eaef);border-radius:10px;padding:18px 22px;transition:box-shadow .18s ease,border-color .18s ease}
	.csuite-faq__item[open]{border-color:var(--global-palette1,#1f6feb);box-shadow:0 6px 24px -16px rgba(0,0,0,.18)}
	.csuite-faq__q{cursor:pointer;font-weight:600;color:var(--global-palette3,#222);font-size:1.05rem;list-style:none;display:flex;align-items:center;justify-content:space-between;gap:14px}
	.csuite-faq__q::-webkit-details-marker{display:none}
	.csuite-faq__q::after{content:"+";font-weight:400;font-size:1.5rem;color:var(--global-palette1,#1f6feb);line-height:1;transition:transform .2s ease}
	.csuite-faq__item[open] .csuite-faq__q::after{content:"−"}
	.csuite-faq__a{margin-top:12px;color:var(--global-palette4,#44525e);line-height:1.65}
	.csuite-faq__a p{margin:0}
	@media(max-width:600px){.csuite-faq{padding:40px 16px}.csuite-faq__item{padding:16px 18px}}
	</style>
	<?php
} );

/**
 * Inject Organization enrichments, drop Person, add Service + FAQ schema.
 */
add_filter( 'rank_math/json_ld', function ( $data, $jsonld ) {
	if ( ! is_array( $data ) ) return $data;

	foreach ( $data as $key => $node ) {
		if ( ! is_array( $node ) || empty( $node['@type'] ) ) continue;

		// Enrich the Organization
		if ( $node['@type'] === 'Organization' && ( $node['@id'] ?? '' ) === CSUITE_ORG_ID ) {
			$node['url']         = 'https://csuitecode.com';
			$node['email']       = 'Info@csuitecode.com';
			$node['description'] = 'CSuite Code is a technology consulting firm helping small and medium-sized businesses and nonprofits with websites, IT support, AI automation, managed cloud, and fractional CTO services.';
			$node['sameAs']      = [ CSUITE_LINKEDIN ];
			$node['areaServed']  = [ '@type' => 'Country', 'name' => 'United States' ];
			$node['knowsAbout']  = [
				'IT consulting',
				'Web development',
				'Managed cloud services',
				'AI integration for small business',
				'Cloud migration',
				'Fractional CTO services',
				'Nonprofit technology',
				'Grant writing software',
			];
			$node['knowsLanguage'] = 'en-US';
			$node['contactPoint']  = [
				'@type'             => 'ContactPoint',
				'contactType'       => 'customer support',
				'email'             => 'Info@csuitecode.com',
				'areaServed'        => 'US',
				'availableLanguage' => 'en',
			];
			$node['founder']  = [ '@id' => 'https://csuitecode.com/#founder' ];
			$data[ $key ] = $node;
		}

		// Drop Rank Math's auto-generated WP author Person nodes (admin user with gravatar etc).
		// We replace with a curated founder Person node below.
		if ( $node['@type'] === 'Person' ) {
			unset( $data[ $key ] );
		}
	}

	$data = array_values( $data );

	// Curated founder Person node (replaces the Rank Math auto-generated WP author)
	$data[] = [
		'@type'       => 'Person',
		'@id'         => 'https://csuitecode.com/#founder',
		'name'        => 'Anthony Colasante',
		'jobTitle'    => 'Founder',
		'worksFor'    => [ '@id' => CSUITE_ORG_ID ],
		'description' => 'Founder of CSuite Code. Proficient across multiple programming languages, modern tech stacks, AI frameworks, and cloud certifications. Helps small businesses and nonprofits modernize their technology without enterprise pricing.',
		'knowsAbout'  => [
			'Software engineering',
			'Cloud architecture',
			'AI integration',
			'Web development',
			'Nonprofit technology',
			'Fractional CTO leadership',
		],
	];

	// Per-page Service schema
	if ( is_singular( 'page' ) ) {
		$post_id = get_queried_object_id();
		if ( $service = csuite_service_for_page( $post_id ) ) {
			$data[] = $service;
		}
		// Per-page FAQ schema
		if ( $faqs = csuite_faqs_for_page( $post_id ) ) {
			$data[] = csuite_faq_schema( $post_id, $faqs );
		}
		// Per-page HowTo schema
		if ( $howto = csuite_howto_for_page( $post_id ) ) {
			$data[] = $howto;
		}
	}

	return $data;
}, 99, 2 );

/**
 * HowTo schema definitions per page ID — describes a step-by-step process.
 */
function csuite_howto_for_page( $post_id ) {
	$howtos = [
		// Nonprofits engagement process
		288 => [
			'name'        => 'How to start a nonprofit technology engagement with CSuite Code',
			'description' => 'Three steps from a free discovery call to an active partnership, including setup of your complimentary GrantMind Pro account.',
			'totalTime'   => 'P14D',
			'steps'       => [
				[
					'name' => 'Discovery Call',
					'text' => 'Schedule a free 30-minute discovery call. We learn about your mission, your team, your current tools, and where things break down. No pitch deck.',
				],
				[
					'name' => 'Tailored Tech Roadmap',
					'text' => 'We map out priorities, set up your GrantMind Pro account, and send you a transparent quote — no surprises and no enterprise upsell.',
				],
				[
					'name' => 'Build, Train, and Stick Around',
					'text' => 'We implement the work, train your team, and stay on as a fractional tech partner — there when grant cycles, audits, or growth call for backup.',
				],
			],
		],
	];

	$post_id = (int) $post_id;
	if ( empty( $howtos[ $post_id ] ) ) return null;

	$data = $howtos[ $post_id ];
	$steps = [];
	foreach ( $data['steps'] as $i => $s ) {
		$steps[] = [
			'@type'    => 'HowToStep',
			'position' => $i + 1,
			'name'     => $s['name'],
			'text'     => $s['text'],
			'url'      => get_permalink( $post_id ) . '#step-' . ( $i + 1 ),
		];
	}
	return [
		'@type'       => 'HowTo',
		'@id'         => get_permalink( $post_id ) . '#howto',
		'name'        => $data['name'],
		'description' => $data['description'],
		'totalTime'   => $data['totalTime'],
		'step'        => $steps,
	];
}

/**
 * Filter out noindexed posts from Rank Math's llms.txt output.
 */
add_filter( 'rank_math/llms_txt/posts_query_args', function ( $args ) {
	$noindex_ids = get_posts( [
		'post_type'      => 'any',
		'post_status'    => 'publish',
		'numberposts'    => -1,
		'fields'         => 'ids',
		'meta_query'     => [
			[
				'key'     => 'rank_math_robots',
				'value'   => 'noindex',
				'compare' => 'LIKE',
			],
		],
	] );
	if ( ! empty( $noindex_ids ) ) {
		$args['post__not_in'] = array_merge( $args['post__not_in'] ?? [], $noindex_ids );
	}
	return $args;
} );

/**
 * Build the FAQPage schema node.
 */
function csuite_faq_schema( $post_id, $faqs ) {
	$main_entity = [];
	foreach ( $faqs as $faq ) {
		$main_entity[] = [
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text'  => $faq['a'],
			],
		];
	}
	return [
		'@type'      => 'FAQPage',
		'@id'        => get_permalink( $post_id ) . '#faq',
		'mainEntity' => $main_entity,
	];
}

/**
 * Service schema definitions per page ID.
 */
function csuite_service_for_page( $post_id ) {
	$base = [
		'@type'      => 'Service',
		'provider'   => [ '@id' => CSUITE_ORG_ID ],
		'areaServed' => [ '@type' => 'Country', 'name' => 'United States' ],
	];

	switch ( (int) $post_id ) {
		case 288: // Nonprofits
			return array_merge( $base, [
				'@id'         => 'https://csuitecode.com/nonprofits/#service',
				'name'        => 'Technology Consulting for Nonprofits',
				'serviceType' => 'Nonprofit Technology Consulting',
				'description' => 'Discounted technology consulting for verified 501(c)(3) organizations, including websites, IT support, AI automation, managed cloud, and fractional tech leadership. Includes complimentary access to GrantMind Pro, an AI-powered grant research and writing platform.',
				'url'         => 'https://csuitecode.com/nonprofits/',
				'audience'    => [
					'@type'        => 'Audience',
					'audienceType' => 'Nonprofit organizations (501(c)(3))',
				],
				'offers'      => [
					'@type'         => 'Offer',
					'description'   => 'Discounted consulting rates and predictable monthly care for verified nonprofits, plus complimentary GrantMind Pro access ($249/month value).',
					'priceCurrency' => 'USD',
					'availability'  => 'https://schema.org/InStock',
					'category'      => 'Nonprofit consulting',
				],
				'isRelatedTo' => [
					'@type'               => 'SoftwareApplication',
					'name'                => 'GrantMind Pro',
					'url'                 => CSUITE_GRANTMIND,
					'applicationCategory' => 'BusinessApplication',
					'description'         => 'AI-powered grant research and proposal writing platform for nonprofits, schools, municipalities, and grant-writing agencies.',
				],
			] );

		case 189: // Cloud Solutions
			return array_merge( $base, [
				'@id'         => 'https://csuitecode.com/managed-cloud/#service',
				'name'        => 'Managed Cloud Services & Migration',
				'serviceType' => 'Managed Cloud Services',
				'description' => 'Done-for-you managed cloud services for small businesses, including S3 migration, backups, disaster recovery, and cost optimization across AWS, Azure, and Google Cloud.',
				'url'         => 'https://csuitecode.com/managed-cloud/',
			] );

		case 162: // AI for Your Business
			return array_merge( $base, [
				'@id'         => 'https://csuitecode.com/ai/#service',
				'name'        => 'AI Integration for Small Businesses',
				'serviceType' => 'AI Consulting and Automation',
				'description' => 'Practical AI integration for small and medium-sized businesses, including chatbots, document automation, workflow AI, and decision-support tools tailored to lean teams.',
				'url'         => 'https://csuitecode.com/ai/',
			] );

		case 225: // Home Services AI Automation
			return array_merge( $base, [
				'@id'         => 'https://csuitecode.com/services-ai-automation/#service',
				'name'        => 'AI Automation for Home Service Businesses',
				'serviceType' => 'AI Automation for Home Services',
				'description' => 'AI-powered automation for HVAC, plumbing, cleaning, and other home service businesses — handling scheduling, invoicing, customer follow-up, and lead routing.',
				'url'         => 'https://csuitecode.com/services-ai-automation/',
			] );

		case 61: // Pricing
			return array_merge( $base, [
				'@id'         => 'https://csuitecode.com/pricing/#service',
				'name'        => 'CSuite Code Service Pricing',
				'serviceType' => 'IT Consulting and Managed Services',
				'description' => 'Transparent pricing for managed IT, AI integrations, cloud services, and fractional CTO engagements tailored to small businesses and nonprofits.',
				'url'         => 'https://csuitecode.com/pricing/',
			] );

		case 59: // Services hub
			return array_merge( $base, [
				'@id'         => 'https://csuitecode.com/services/#service',
				'name'        => 'CSuite Code Services',
				'serviceType' => 'Technology Consulting',
				'description' => 'Web development, IT support, AI automation, managed cloud, and fractional CTO services for small businesses and nonprofits.',
				'url'         => 'https://csuitecode.com/services/',
			] );
	}

	return null;
}
