<?php
/**
 * Plugin Name: CSuite Code Schema Enhancements
 * Description: Enriches Organization schema, adds Service & FAQ schema, and renders FAQ blocks via shortcode.
 * Version: 1.1.0
 * Author: CSuite Code
 */

if ( ! defined( 'ABSPATH' ) ) exit;

const CSUITE_ORG_ID = 'https://csuitecode.com/#organization';
const CSUITE_LINKEDIN = 'https://www.linkedin.com/company/c-suite-code/';
const CSUITE_GRANTMIND = 'https://grantmind.pro/';

/**
 * FAQ definitions per page ID. Single source of truth - used for both visible
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
			 'a' => 'We use a mix of fixed-fee project quotes, hourly consulting, and predictable monthly care packages - whichever fits your budget and risk tolerance best.' ],
		],

		// Services (59)
		59 => [
			[ 'q' => 'What services does CSuite Code offer?',
			 'a' => 'We cover websites and web applications, IT support, AI integration and automation, managed cloud services and migrations, and fractional CTO leadership. All services are sized for small businesses and nonprofits.' ],
			[ 'q' => 'Can CSuite Code handle a project end-to-end?',
			 'a' => 'Yes - we design, build, deploy, train your team, and maintain the system. You do not need to coordinate multiple vendors. We can also slot in alongside your existing IT staff or developers when that makes sense.' ],
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
			 'a' => 'Most clients save 25 to 40 percent on storage costs by switching to S3-compatible alternatives - without changing the applications that use them.' ],
			[ 'q' => 'Do you handle backups and disaster recovery?',
			 'a' => 'Yes. We set up automated, encrypted backups with off-site replication and document a tested recovery process so you know exactly what happens if something goes wrong.' ],
		],

		// AI for Your Business (162)
		162 => [
			[ 'q' => 'Is my business big enough to benefit from AI?',
			 'a' => 'If your team handles repetitive tasks - email triage, document review, customer follow-ups, scheduling, data entry - AI can give hours back every week. Most of our AI clients have between 5 and 50 employees.' ],
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
			 'a' => 'GrantMind Pro is our AI-powered grant research and proposal-writing platform - normally a $249 per month subscription. While you are an active CSuite Code nonprofit client, your team\'s access is included at no additional cost.' ],
			[ 'q' => 'Does CSuite Code write grant proposals on our behalf?',
			 'a' => 'Through GrantMind Pro, your team gets AI-assisted drafting across the nine standard proposal sections, plus pre-submission scoring. We do not write proposals for you, but we make it dramatically faster for your team to do. If you would rather have a professional work with you one-on-one, we partner with <a href="https://npograntwriting.com" target="_blank" rel="noopener">NPO Grant Writing</a> - they can work with your organization on retainer.' ],
			[ 'q' => 'What kinds of nonprofits typically work with you?',
			 'a' => 'Community-based 501(c)(3) organizations, schools, and small foundations across the United States. We are best suited to organizations that need a long-term tech partner, not a one-off project.' ],
			[ 'q' => 'How do you verify 501(c)(3) status to qualify for the discount?',
			 'a' => 'We ask for your IRS determination letter or your EIN to confirm 501(c)(3) status. Once verified, the discount applies to all engagements.' ],
		],

		// Philadelphia nonprofits (339)
		339 => [
			[ 'q' => 'Are you actually based in Philadelphia?',
			 'a' => 'Yes. CSuite Code is based in the Greater Philadelphia region. We work with nonprofits across Philadelphia, Bucks, Chester, Delaware, and Montgomery counties — as well as South Jersey clients within driving distance.' ],
			[ 'q' => 'Do you work with Philadelphia nonprofits in person?',
			 'a' => 'Many engagements start with an in-person kickoff in Center City or wherever your office is. Day-to-day work is remote (faster and cheaper for you), but we drive over for board presentations, training sessions, and event support when it matters.' ],
			[ 'q' => 'What kinds of Philadelphia nonprofits do you typically work with?',
			 'a' => 'Education-focused nonprofits, community-based social services orgs, arts and cultural institutions, charter schools, mentoring programs, and small foundations. Anywhere from West Philly to the Main Line, Camden to Cherry Hill.' ],
			[ 'q' => 'Do you know Philadelphia-specific funders and grant calendars?',
			 'a' => 'Yes. GrantMind Pro (included with your engagement) covers the William Penn Foundation, Pew Charitable Trusts, the Independence Public Media Foundation, the Philadelphia Foundation, and dozens of other regional funders — plus state grants through Pennsylvania DCED and federal opportunities.' ],
			[ 'q' => 'How do I verify my Philadelphia nonprofit qualifies for the discount?',
			 'a' => 'Send us your IRS determination letter or EIN. Once we confirm 501(c)(3) status, the discount applies to all engagements. Smaller orgs (under $500K annual budget) qualify for our deepest tier.' ],
		],

		// Pennsylvania nonprofits (340)
		340 => [
			[ 'q' => 'Do you serve nonprofits across all of Pennsylvania?',
			 'a' => 'Yes. We work with 501(c)(3) organizations statewide — Greater Philadelphia, the Lehigh Valley, Central PA, Pittsburgh, Erie, and the rural regions in between. Most engagements are remote-first; we travel for kickoff meetings and major milestones.' ],
			[ 'q' => 'Are you familiar with Pennsylvania state grant programs?',
			 'a' => 'GrantMind Pro tracks Pennsylvania DCED grants, the Pennsylvania Council on the Arts, the Department of Human Services contracting opportunities, and regional community foundations from the Heinz Endowments in Pittsburgh to the Lehigh Valley Community Foundation. It is included free during your engagement.' ],
			[ 'q' => 'Can you serve nonprofits in Pittsburgh, even though you are in Philadelphia?',
			 'a' => 'Yes. We work remotely with clients in Pittsburgh, Erie, and Western PA. Modern collaboration tools make 300 miles a non-issue for day-to-day work; we travel for important milestones if needed.' ],
			[ 'q' => 'What types of Pennsylvania nonprofits do you typically work with?',
			 'a' => 'Education, healthcare, social services, arts and culture, immigrant services, environmental, and community development organizations. We are sized for orgs with under-$5M budgets and lean staffs.' ],
			[ 'q' => 'How do you verify Pennsylvania nonprofit status?',
			 'a' => 'Send your IRS determination letter or EIN. Once we confirm 501(c)(3) status, the discount applies to all engagements. Smaller orgs (under $500K annual budget) qualify for our deepest tier.' ],
		],

		// New Jersey nonprofits (341)
		341 => [
			[ 'q' => 'Do you serve nonprofits across New Jersey?',
			 'a' => 'Yes. We work with 501(c)(3) organizations throughout New Jersey — South Jersey (Camden, Cherry Hill, Vineland, Atlantic City), Central Jersey (Trenton, Princeton, New Brunswick), and North Jersey (Newark, Jersey City, Hoboken).' ],
			[ 'q' => 'Are you familiar with New Jersey state grant programs?',
			 'a' => 'GrantMind Pro tracks NJEDA, the New Jersey State Council on the Arts, the Department of Human Services, regional community foundations, and the major private funders including the Robert Wood Johnson Foundation, Geraldine R. Dodge Foundation, and Prudential Foundation. Included free during your engagement.' ],
			[ 'q' => 'How does a Philadelphia-based team serve New Jersey nonprofits?',
			 'a' => 'We are based in the Greater Philadelphia region, just across the Delaware. We drive over to South Jersey for kickoffs, board presentations, and event support. North Jersey and the Shore are served remotely — we work with most clients via video and async messaging, which keeps costs low.' ],
			[ 'q' => 'What types of New Jersey nonprofits do you typically work with?',
			 'a' => 'Youth services, food security, arts and culture, faith-based, healthcare, environmental, and community development organizations. We are sized for orgs with under-$5M budgets and lean staffs.' ],
			[ 'q' => 'How do you verify New Jersey nonprofit status?',
			 'a' => 'Send your IRS determination letter or EIN. Once we confirm 501(c)(3) status, the discount applies to all engagements. Smaller orgs (under $500K annual budget) qualify for our deepest tier.' ],
		],

		// Nonprofit IT Support (346)
		346 => [
			[ 'q' => 'What is nonprofit IT support, exactly?',
			 'a' => 'Nonprofit IT support is the day-to-day work of keeping your technology running: helpdesk for staff laptops and email, security patching, backup and recovery, monitoring, and answering questions when something breaks. CSuite Code provides discounted IT support for verified 501(c)(3) organizations.' ],
			[ 'q' => 'How much does nonprofit IT support cost?',
			 'a' => 'A reasonable benchmark is 2-5% of annual operating budget for total IT spend. For a $500,000-budget nonprofit, that means roughly $10,000-$25,000 per year on technology including software and external support. Nonprofit-priced managed plans typically run $1,500-$2,500 per month and bundle most of what you need.' ],
			[ 'q' => 'What is the difference between nonprofit IT support and a managed service provider (MSP)?',
			 'a' => 'IT support is operational - keeping things running and fixing things that break. A managed service provider (MSP) bundles IT support with strategic planning, vendor management, security monitoring, and ongoing improvements under a single predictable monthly fee. See our nonprofit managed services page for a full comparison.' ],
			[ 'q' => 'Do you only support nonprofits in Philadelphia?',
			 'a' => 'No. We are based in the Greater Philadelphia region but work remotely with nonprofits across Pennsylvania, New Jersey, and the broader United States. We travel to local clients for kickoffs and major milestones; remote-only engagements work fine for the rest of the country.' ],
			[ 'q' => 'What if my nonprofit already has someone doing IT?',
			 'a' => 'Many of our clients have an internal IT person or volunteer. We slot in alongside them - handling the things they do not have time for, providing CTO-level guidance, or being the backup when they are on vacation. We do not require you to replace anyone.' ],
		],

		// Nonprofit Managed Services / MSP (347)
		347 => [
			[ 'q' => 'What is a nonprofit MSP (managed service provider)?',
			 'a' => 'A nonprofit MSP is a single technology partner that handles your full IT stack - hosting, security, monitoring, helpdesk, software updates, backups, and strategic guidance - for a predictable monthly fee. Instead of juggling a hosting bill, a security tool, a CRM admin, and a part-time IT helper, you get all of it under one engagement.' ],
			[ 'q' => 'How is a nonprofit MSP different from hourly IT support?',
			 'a' => 'Hourly IT support is reactive: you pay when something breaks. A managed service provider is proactive: monitoring, patching, and backups happen continuously, so things rarely break. For nonprofits with daily technology needs (donor portals, email, event registration) the managed model is almost always cheaper and less stressful.' ],
			[ 'q' => 'How much does a nonprofit MSP cost?',
			 'a' => 'Typical MSP pricing for nonprofits runs $1,500-$10,000 per month depending on staff count, scope, and complexity. CSuite Code offers verified-501(c)(3) discounted pricing - our Growth plan is $2,497 per month and our Enterprise plan is $4,997 per month. Both include complimentary GrantMind Pro access ($249/month value).' ],
			[ 'q' => 'Are there contracts or minimum commitments?',
			 'a' => 'No. Our managed service engagements are month-to-month. You can scale up or down as your funding changes, or end the engagement with 30 days notice. We earn your business every month, not via a contract penalty.' ],
			[ 'q' => 'Does a nonprofit MSP replace an in-house IT person?',
			 'a' => 'For most small nonprofits (under 50 staff), an MSP is more economical than a full-time hire. A senior IT person costs $70,000-$130,000 plus benefits; a managed service plan costs a fraction of that and gives you a team rather than a single person. Larger nonprofits often combine an internal IT lead with an MSP for backup and strategic guidance.' ],
		],

		// Nonprofit Tech Support (348)
		348 => [
			[ 'q' => 'How fast can you respond when something is broken?',
			 'a' => 'For verified nonprofit clients, our average first response is under one hour during business hours. For emergencies (donor page down, payment processing broken), we take same-day priority engagement.' ],
			[ 'q' => 'Do I have to be on a monthly plan to get tech support?',
			 'a' => 'No. We offer hourly tech support at $150 per hour with verified-nonprofit discounts. Best for orgs with occasional needs. For organizations with daily tech support needs, a monthly care plan is usually more economical and includes faster response.' ],
			[ 'q' => 'What kinds of tech problems do you handle?',
			 'a' => 'Donation page issues (Stripe, PayPal, donor receipts), email and Google Workspace/Microsoft 365 problems, account lockouts and MFA setup, CRM-to-accounting sync (Bloomerang, Salesforce NPSP, QuickBooks), WordPress and website breakage, staff laptop setup, and the general "something stopped working" calls that derail your day.' ],
			[ 'q' => 'Can you take an emergency engagement?',
			 'a' => 'Yes. Book the next available slot on our calendar. We diagnose the problem on the call and quote the fix on the spot. Standard hourly rates apply, with verified-nonprofit discounts available.' ],
		],

		// Nonprofit Web Design (349)
		349 => [
			[ 'q' => 'What platform do you build nonprofit websites on?',
			 'a' => 'WordPress for most engagements - because your team can update content without a developer, and the donor tooling ecosystem (Stripe, Bloomerang, FluentCRM, EventBrite) integrates natively. We can build on other platforms (Webflow, custom React/Next.js) for orgs with specific requirements.' ],
			[ 'q' => 'How much does a nonprofit website cost?',
			 'a' => 'A polished donation-ready site typically runs $5,000-$25,000 depending on scope. A simple refresh of an existing site can be as low as $2,500. We include site audits free in your discovery call and quote a fixed price after.' ],
			[ 'q' => 'Will the site be WCAG / ADA accessible?',
			 'a' => 'Yes. Every site we build meets WCAG 2.1 AA standards: color contrast, keyboard navigation, screen-reader markup, alt text, and captioned media. This is increasingly required by NEA, state arts councils, and major foundation funders.' ],
			[ 'q' => 'Will my donor data sync between the site and our CRM?',
			 'a' => 'Yes. We integrate your donation forms with Bloomerang, Salesforce NPSP, DonorPerfect, or whatever CRM you use. New donors are automatically created with proper tagging, and recurring giving syncs without manual reconciliation.' ],
		],

		// Pillar guide (350)
		350 => [
			[ 'q' => 'Is this guide free?',
			 'a' => 'Yes. The complete guide is free to read on this page. No email gate. If you want a PDF copy or a discovery call to walk through how it applies to your nonprofit, you can book a 30-minute call at no cost.' ],
			[ 'q' => 'Who should read this guide?',
			 'a' => 'Executive directors, operations directors, and board members of small to mid-sized nonprofits (under 50 staff) who are evaluating in-house IT, an MSP, or hourly support. The guide is written in plain English for non-technical readers.' ],
			[ 'q' => 'Does this guide apply to nonprofits outside Pennsylvania?',
			 'a' => 'Yes. The principles - budgeting, security, choosing a provider, AI wins - apply to any 501(c)(3) organization in the United States. The cost benchmarks reflect mid-Atlantic pricing; West Coast and major metros tend to run 20-30% higher.' ],
		],

		// Education Nonprofits (351)
		351 => [
			[ 'q' => 'Are you FERPA-experienced?',
			 'a' => 'Yes. We architect education-nonprofit tech with FERPA principles in mind: access controls on student data, audit trails, vendor data-sharing agreements, and the documentation accreditors expect. We are not FERPA auditors but we set systems up to support compliance.' ],
			[ 'q' => 'Which student information systems (SIS) do you support?',
			 'a' => 'PowerSchool, Schoology, Infinite Campus, Aspen, and a number of charter-school-specific SIS platforms. We handle initial setup, integrations with your LMS and donor CRM, parent portal configuration, and ongoing admin.' ],
			[ 'q' => 'Do you work with charter schools specifically?',
			 'a' => 'Yes. Charter schools have unique tech needs - state reporting, authorizer documentation, growing student enrollment with limited admin staff. We are sized to support charter networks of 1-5 campuses.' ],
		],

		// Arts Nonprofits (352)
		352 => [
			[ 'q' => 'Which ticketing systems do you support?',
			 'a' => 'Patron Manager (Salesforce), Spektrix, Tessitura, EventBrite, and a few smaller platforms. We handle admin, integrations between your ticketing and donor CRM, and reporting workflows for marketing and box-office teams.' ],
			[ 'q' => 'Do you handle accessibility audits for arts organizations?',
			 'a' => 'Yes. We audit websites to WCAG 2.1 AA standards and provide remediation plans. This is increasingly required by NEA, state arts councils (PA Council on the Arts, NJ State Council on the Arts), and major arts funders.' ],
			[ 'q' => 'Can you help with gala and benefit event tech?',
			 'a' => 'Yes. Auction software (GiveSmart, OneCause), paddle-raise apps, sponsor recognition tools, and integration with your donor CRM so the data flows back without manual reconciliation.' ],
		],

		// Healthcare Nonprofits (353)
		353 => [
			[ 'q' => 'Are you HIPAA-compliant?',
			 'a' => 'We are not a HIPAA compliance auditor. We architect IT in a way that supports HIPAA - access controls, encrypted transport, audit logs, BAA-signed vendors (Twilio, Zoom for Healthcare, Doxy.me), and documented incident response. For formal HIPAA compliance audits, we work with specialized auditors as needed.' ],
			[ 'q' => 'Which telehealth platforms do you set up?',
			 'a' => 'Zoom for Healthcare, Doxy.me, and SimplePractice are the most common. We handle initial setup, BAA execution, integration with your scheduling and EHR, and volunteer-provider onboarding workflows.' ],
			[ 'q' => 'Do you support FQHC-equivalents or just free clinics?',
			 'a' => 'We support a spectrum of healthcare nonprofits: free clinics, FQHC look-alikes and equivalents, community health organizations, patient advocacy nonprofits, and disease-specific foundations. Sizing varies but our discount applies to verified 501(c)(3) status regardless of subtype.' ],
		],
	];

	$post_id = (int) $post_id;
	return $faqs[ $post_id ] ?? null;
}

/**
 * Related services per page ID - appended after content via the_content filter.
 */
function csuite_related_links_for_page( $post_id ) {
	$related = [
		// Cloud Solutions
		189 => [
			'heading' => 'Related services',
			'links' => [
				[ 'url' => '/ai/', 'label' => 'AI integration for small businesses', 'desc' => 'Automation and chatbots, sized for lean teams.' ],
				[ 'url' => '/nonprofits/', 'label' => 'Nonprofits', 'desc' => 'Discounted cloud rates plus complimentary GrantMind Pro access.' ],
			],
		],
		// AI for Your Business
		162 => [
			'heading' => 'Related services',
			'links' => [
				[ 'url' => '/services-ai-automation/', 'label' => 'AI for home service businesses', 'desc' => 'Scheduling, invoicing, and follow-up automation for HVAC, plumbing, and cleaning teams.' ],
				[ 'url' => '/managed-cloud/', 'label' => 'Managed cloud services', 'desc' => 'Where your AI workloads run, monitored and right-sized.' ],
				[ 'url' => '/nonprofits/', 'label' => 'Nonprofits', 'desc' => 'Discounted AI engagements for verified 501(c)(3) organizations.' ],
			],
		],
		// Home Services AI Automation
		225 => [
			'heading' => 'Related services',
			'links' => [
				[ 'url' => '/ai/', 'label' => 'AI integration for small businesses', 'desc' => 'Broader AI consulting beyond home services workflows.' ],
				[ 'url' => '/services/', 'label' => 'All CSuite Code services', 'desc' => 'Web development, IT support, cloud, and fractional CTO work.' ],
			],
		],
		// Nonprofits
		288 => [
			'heading' => 'Related services',
			'links' => [
				[ 'url' => '/ai/', 'label' => 'AI integration', 'desc' => 'Practical automation for lean nonprofit teams.' ],
				[ 'url' => '/managed-cloud/', 'label' => 'Managed cloud services', 'desc' => 'Hosting, backups, and migration with nonprofit pricing.' ],
			],
		],
		// Pricing
		61 => [
			'heading' => 'Service details',
			'links' => [
				[ 'url' => '/services/', 'label' => 'See all services', 'desc' => 'Web, IT, AI, cloud, and fractional CTO offerings.' ],
				[ 'url' => '/nonprofits/', 'label' => 'Nonprofit pricing', 'desc' => 'Discounted rates and free GrantMind Pro for verified 501(c)(3) orgs.' ],
			],
		],
		// Services hub
		59 => [
			'heading' => 'Specialized engagements',
			'links' => [
				[ 'url' => '/nonprofits/', 'label' => 'For nonprofits', 'desc' => 'Discounted rates and complimentary GrantMind Pro access.' ],
				[ 'url' => '/services-ai-automation/', 'label' => 'For home service businesses', 'desc' => 'AI automation built for HVAC, plumbing, and cleaning teams.' ],
			],
		],
		// Philadelphia nonprofits (339)
		339 => [
			'heading' => 'Also serving',
			'links' => [
				[ 'url' => '/nonprofits-pennsylvania/', 'label' => 'Pennsylvania nonprofits', 'desc' => 'Statewide coverage across PA - from the Lehigh Valley to Pittsburgh.' ],
				[ 'url' => '/nonprofits-new-jersey/', 'label' => 'New Jersey nonprofits', 'desc' => 'South Jersey and beyond - just across the Delaware.' ],
				[ 'url' => '/nonprofits/', 'label' => 'Nonprofit services overview', 'desc' => 'The full breakdown of what we do for nonprofits.' ],
			],
		],
		// Pennsylvania nonprofits (340)
		340 => [
			'heading' => 'Also serving',
			'links' => [
				[ 'url' => '/nonprofits-philadelphia/', 'label' => 'Philadelphia nonprofits', 'desc' => 'Local hands-on partnership for Greater Philly orgs.' ],
				[ 'url' => '/nonprofits-new-jersey/', 'label' => 'New Jersey nonprofits', 'desc' => 'Just across the Delaware. South, Central, and North Jersey.' ],
				[ 'url' => '/nonprofits/', 'label' => 'Nonprofit services overview', 'desc' => 'The full breakdown of what we do for nonprofits.' ],
			],
		],
		// New Jersey nonprofits (341)
		341 => [
			'heading' => 'Also serving',
			'links' => [
				[ 'url' => '/nonprofits-philadelphia/', 'label' => 'Philadelphia nonprofits', 'desc' => 'Across the Delaware. Local hands-on partnership in PHL.' ],
				[ 'url' => '/nonprofits-pennsylvania/', 'label' => 'Pennsylvania nonprofits', 'desc' => 'Statewide coverage across the commonwealth.' ],
				[ 'url' => '/nonprofits/', 'label' => 'Nonprofit services overview', 'desc' => 'The full breakdown of what we do for nonprofits.' ],
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
 * Render shortcode - visible FAQ section on the page.
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

		// Enrich the Organization → upgrade to ProfessionalService (a LocalBusiness type)
		if ( $node['@type'] === 'Organization' && ( $node['@id'] ?? '' ) === CSUITE_ORG_ID ) {
			$node['@type'] = [ 'Organization', 'ProfessionalService', 'LocalBusiness' ];
			$node['url'] = 'https://csuitecode.com';
			$node['email'] = 'Info@csuitecode.com';
			$node['description'] = 'CSuite Code is a Philadelphia-based technology consulting firm helping nonprofits and small businesses across Pennsylvania and New Jersey with websites, IT support, AI automation, managed cloud, and fractional CTO services.';
			$node['sameAs'] = [ CSUITE_LINKEDIN ];
			$node['address'] = [
				'@type' => 'PostalAddress',
				'addressLocality' => 'Philadelphia',
				'addressRegion' => 'PA',
				'addressCountry' => 'US',
			];
			$node['geo'] = [
				'@type' => 'GeoCoordinates',
				'latitude' => 39.9526,
				'longitude' => -75.1652,
			];
			$node['areaServed'] = [
				[ '@type' => 'City', 'name' => 'Philadelphia' ],
				[ '@type' => 'State', 'name' => 'Pennsylvania' ],
				[ '@type' => 'State', 'name' => 'New Jersey' ],
				[ '@type' => 'AdministrativeArea', 'name' => 'Greater Philadelphia Region' ],
				[ '@type' => 'Country', 'name' => 'United States' ],
			];
			$node['serviceArea'] = [
				'@type' => 'GeoCircle',
				'geoMidpoint' => [
					'@type' => 'GeoCoordinates',
					'latitude' => 39.9526,
					'longitude' => -75.1652,
				],
				'geoRadius' => '150000',
			];
			$node['knowsAbout'] = [
				'Nonprofit technology consulting',
				'IT consulting for nonprofits in Philadelphia',
				'Technology services for Pennsylvania nonprofits',
				'Technology services for New Jersey nonprofits',
				'Web development',
				'Managed cloud services',
				'AI integration for small business',
				'Cloud migration',
				'Fractional CTO services',
				'Grant writing software',
			];
			$node['knowsLanguage'] = 'en-US';
			$node['contactPoint'] = [
				'@type' => 'ContactPoint',
				'contactType' => 'customer support',
				'email' => 'Info@csuitecode.com',
				'areaServed' => [ 'US-PA', 'US-NJ' ],
				'availableLanguage' => 'en',
			];
			$node['founder'] = [ '@id' => 'https://csuitecode.com/#founder' ];
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
		'@type' => 'Person',
		'@id' => 'https://csuitecode.com/#founder',
		'name' => 'Anthony Colasante',
		'jobTitle' => 'Founder',
		'worksFor' => [ '@id' => CSUITE_ORG_ID ],
		'description' => 'Founder of CSuite Code. Proficient across multiple programming languages, modern tech stacks, AI frameworks, and cloud certifications. Helps small businesses and nonprofits modernize their technology without enterprise pricing.',
		'knowsAbout' => [
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
 * HowTo schema definitions per page ID - describes a step-by-step process.
 */
function csuite_howto_for_page( $post_id ) {
	$howtos = [
		// Home engagement process
		57 => [
			'name' => 'How to start a technology engagement with CSuite Code',
			'description' => 'Three steps from a free discovery call to a working tech setup tailored for your small business or nonprofit.',
			'totalTime' => 'P14D',
			'steps' => [
				[ 'name' => 'Discovery Call', 'text' => 'Tell us about your mission, your tools, and where things break down. 30 minutes, no pitch deck.' ],
				[ 'name' => 'Tailored Roadmap', 'text' => 'We map priorities and send a transparent quote. No surprises, no enterprise upsell.' ],
				[ 'name' => 'Build, Train, Stick Around', 'text' => 'We implement, train your team, and stay on as a fractional tech partner.' ],
			],
		],

		// Services hub process
		59 => [
			'name' => 'How an engagement with CSuite Code starts',
			'description' => 'Three steps from first contact to an active fractional tech partnership.',
			'totalTime' => 'P14D',
			'steps' => [
				[ 'name' => 'Discovery Call', 'text' => 'Tell us about your tools, your team, and where things break down. 30 minutes, no pitch deck.' ],
				[ 'name' => 'Tailored Roadmap', 'text' => 'We map priorities and send a transparent quote. No surprises, no enterprise upsell.' ],
				[ 'name' => 'Build, Train, Stick Around', 'text' => 'We implement, train your team, and stay on as a fractional tech partner.' ],
			],
		],

		// AI Integration process
		162 => [
			'name' => 'How to ship your first AI win in four weeks',
			'description' => 'Three steps from workflow audit to shipped AI automation for a small business.',
			'totalTime' => 'P28D',
			'steps' => [
				[ 'name' => 'Workflow Audit', 'text' => '30-minute call to find the repetitive work your team spends the most time on.' ],
				[ 'name' => 'Pick One & Build', 'text' => 'We pick a single high-leverage automation, build it, test it, and ship it.' ],
				[ 'name' => 'Expand', 'text' => 'Once the first win is in production, we plan the next one. AI infrastructure folds into a monthly care package.' ],
			],
		],

		// Contact / what happens next
		60 => [
			'name' => 'What happens after you book a discovery call with CSuite Code',
			'description' => 'Three steps that follow a successful discovery-call booking.',
			'totalTime' => 'P2D',
			'steps' => [
				[ 'name' => 'Confirmation', 'text' => 'You receive a calendar invite with a Google Meet link, plus a short questionnaire so we come prepared.' ],
				[ 'name' => 'The Call', 'text' => 'Bring your questions. We review your stack, your goals, and identify your biggest tech opportunities.' ],
				[ 'name' => 'Tailored Quote', 'text' => 'Within 48 hours we send a written roadmap and quote. No surprises, no high-pressure pitches.' ],
			],
		],

		// Nonprofits engagement process (unchanged)
		288 => [
			'name' => 'How to start a nonprofit technology engagement with CSuite Code',
			'description' => 'Three steps from a free discovery call to an active partnership, including setup of your complimentary GrantMind Pro account.',
			'totalTime' => 'P14D',
			'steps' => [
				[ 'name' => 'Discovery Call', 'text' => 'Schedule a free 30-minute discovery call. We learn about your mission, your team, your current tools, and where things break down. No pitch deck.' ],
				[ 'name' => 'Tailored Tech Roadmap', 'text' => 'We map out priorities, set up your GrantMind Pro account, and send you a transparent quote - no surprises and no enterprise upsell.' ],
				[ 'name' => 'Build, Train, and Stick Around', 'text' => 'We implement the work, train your team, and stay on as a fractional tech partner - there when grant cycles, audits, or growth call for backup.' ],
			],
		],
	];

	$post_id = (int) $post_id;
	if ( empty( $howtos[ $post_id ] ) ) return null;

	$data = $howtos[ $post_id ];
	$steps = [];
	foreach ( $data['steps'] as $i => $s ) {
		$steps[] = [
			'@type' => 'HowToStep',
			'position' => $i + 1,
			'name' => $s['name'],
			'text' => $s['text'],
			'url' => get_permalink( $post_id ) . '#step-' . ( $i + 1 ),
		];
	}
	return [
		'@type' => 'HowTo',
		'@id' => get_permalink( $post_id ) . '#howto',
		'name' => $data['name'],
		'description' => $data['description'],
		'totalTime' => $data['totalTime'],
		'step' => $steps,
	];
}

/**
 * Filter out noindexed posts from Rank Math's llms.txt output.
 */
add_filter( 'rank_math/llms_txt/posts_query_args', function ( $args ) {
	$noindex_ids = get_posts( [
		'post_type' => 'any',
		'post_status' => 'publish',
		'numberposts' => -1,
		'fields' => 'ids',
		'meta_query' => [
			[
				'key' => 'rank_math_robots',
				'value' => 'noindex',
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
			'@type' => 'Question',
			'name' => $faq['q'],
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text' => $faq['a'],
			],
		];
	}
	return [
		'@type' => 'FAQPage',
		'@id' => get_permalink( $post_id ) . '#faq',
		'mainEntity' => $main_entity,
	];
}

/**
 * Service schema definitions per page ID.
 */
function csuite_service_for_page( $post_id ) {
	$base = [
		'@type' => 'Service',
		'provider' => [ '@id' => CSUITE_ORG_ID ],
		'areaServed' => [ '@type' => 'Country', 'name' => 'United States' ],
	];

	switch ( (int) $post_id ) {
		case 339: // Philadelphia nonprofits
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofits-philadelphia/#service',
				'name' => 'Technology Services for Philadelphia Nonprofits',
				'serviceType' => 'Nonprofit Technology Consulting',
				'description' => 'Philadelphia-based fractional tech team for 501(c)(3) organizations across the city and Greater Philadelphia region. Discounted rates, GrantMind Pro AI grant platform included.',
				'url' => 'https://csuitecode.com/nonprofits-philadelphia/',
				'areaServed' => [
					[ '@type' => 'City', 'name' => 'Philadelphia', 'containedInPlace' => [ '@type' => 'State', 'name' => 'Pennsylvania' ] ],
					[ '@type' => 'AdministrativeArea', 'name' => 'Greater Philadelphia' ],
				],
				'audience' => [
					'@type' => 'Audience',
					'audienceType' => 'Philadelphia nonprofit organizations (501(c)(3))',
					'geographicArea' => [ '@type' => 'City', 'name' => 'Philadelphia' ],
				],
			] );

		case 340: // Pennsylvania nonprofits
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofits-pennsylvania/#service',
				'name' => 'Technology Services for Pennsylvania Nonprofits',
				'serviceType' => 'Nonprofit Technology Consulting',
				'description' => 'Statewide technology services for Pennsylvania 501(c)(3) organizations - from Greater Philadelphia to Pittsburgh, the Lehigh Valley to Erie. Discounted rates and complimentary GrantMind Pro access.',
				'url' => 'https://csuitecode.com/nonprofits-pennsylvania/',
				'areaServed' => [
					[ '@type' => 'State', 'name' => 'Pennsylvania' ],
				],
				'audience' => [
					'@type' => 'Audience',
					'audienceType' => 'Pennsylvania nonprofit organizations (501(c)(3))',
					'geographicArea' => [ '@type' => 'State', 'name' => 'Pennsylvania' ],
				],
			] );

		case 341: // New Jersey nonprofits
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofits-new-jersey/#service',
				'name' => 'Technology Services for New Jersey Nonprofits',
				'serviceType' => 'Nonprofit Technology Consulting',
				'description' => 'Statewide technology services for New Jersey 501(c)(3) organizations from a Philadelphia-area team. Camden, Cherry Hill, Trenton, Princeton, Newark, Jersey City, and the Shore. Discounted rates and free GrantMind Pro access.',
				'url' => 'https://csuitecode.com/nonprofits-new-jersey/',
				'areaServed' => [
					[ '@type' => 'State', 'name' => 'New Jersey' ],
				],
				'audience' => [
					'@type' => 'Audience',
					'audienceType' => 'New Jersey nonprofit organizations (501(c)(3))',
					'geographicArea' => [ '@type' => 'State', 'name' => 'New Jersey' ],
				],
			] );

		case 346: // Nonprofit IT Support
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofit-it-support/#service',
				'name' => 'Nonprofit IT Support',
				'serviceType' => 'IT Support for Nonprofit Organizations',
				'description' => 'Day-to-day IT support, security patching, monitoring, backups, and helpdesk for verified 501(c)(3) organizations. Discounted nonprofit pricing and direct engineer access.',
				'url' => 'https://csuitecode.com/nonprofit-it-support/',
				'audience' => [ '@type' => 'Audience', 'audienceType' => 'Nonprofit organizations (501(c)(3))' ],
			] );

		case 347: // Nonprofit Managed Services / MSP
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofit-managed-services/#service',
				'name' => 'Nonprofit Managed Services (MSP)',
				'serviceType' => 'Managed IT Services for Nonprofits',
				'description' => 'Full-stack managed service provider (MSP) for 501(c)(3) organizations. One predictable monthly fee covers IT, web, security, helpdesk, backups, and AI tooling. Month-to-month, discounted nonprofit pricing.',
				'url' => 'https://csuitecode.com/nonprofit-managed-services/',
				'audience' => [ '@type' => 'Audience', 'audienceType' => 'Nonprofit organizations (501(c)(3))' ],
				'offers' => [
					'@type' => 'Offer',
					'description' => 'Growth managed plan ($2,497/mo) or Enterprise managed plan ($4,997/mo) - both include complimentary GrantMind Pro access ($249/mo value).',
					'priceCurrency' => 'USD',
					'availability' => 'https://schema.org/InStock',
				],
			] );

		case 348: // Nonprofit Tech Support
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofit-tech-support/#service',
				'name' => 'Nonprofit Tech Support',
				'serviceType' => 'Tech Support for Nonprofit Organizations',
				'description' => 'On-demand tech support for 501(c)(3) organizations - donation page issues, email problems, account lockouts, integrations, and website breakage. Hourly or monthly, real-engineer access.',
				'url' => 'https://csuitecode.com/nonprofit-tech-support/',
				'audience' => [ '@type' => 'Audience', 'audienceType' => 'Nonprofit organizations (501(c)(3))' ],
			] );

		case 349: // Nonprofit Web Design
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofit-web-design/#service',
				'name' => 'Nonprofit Web Design and Development',
				'serviceType' => 'Web Design for Nonprofit Organizations',
				'description' => 'WordPress and custom web design and development for 501(c)(3) organizations. WCAG 2.1 AA accessibility, fast page speed, donor-ready forms, and analytics built in. Discounted nonprofit rates.',
				'url' => 'https://csuitecode.com/nonprofit-web-design/',
				'audience' => [ '@type' => 'Audience', 'audienceType' => 'Nonprofit organizations (501(c)(3))' ],
			] );

		case 351: // Education Nonprofits
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofit-it-support-education/#service',
				'name' => 'IT Support for Education Nonprofits',
				'serviceType' => 'IT Support for Education Nonprofits and Charter Schools',
				'description' => 'FERPA-aware IT support for education nonprofits, charter schools, mentoring programs, and college-access organizations. SIS/LMS admin, donor management, AI tutoring integration.',
				'url' => 'https://csuitecode.com/nonprofit-it-support-education/',
				'audience' => [ '@type' => 'EducationalAudience', 'educationalRole' => 'Education nonprofit organizations' ],
			] );

		case 352: // Arts Nonprofits
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofit-it-support-arts/#service',
				'name' => 'IT Support for Arts and Cultural Nonprofits',
				'serviceType' => 'IT Support for Arts Organizations',
				'description' => 'Tech support, ticketing, donor CRM, and accessible web design for arts and cultural nonprofits - galleries, theaters, music programs, museums, and community arts organizations.',
				'url' => 'https://csuitecode.com/nonprofit-it-support-arts/',
				'audience' => [ '@type' => 'Audience', 'audienceType' => 'Arts and cultural nonprofit organizations' ],
			] );

		case 353: // Healthcare Nonprofits
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofit-it-support-healthcare/#service',
				'name' => 'IT Support for Healthcare Nonprofits',
				'serviceType' => 'HIPAA-aware IT Support for Healthcare Nonprofits',
				'description' => 'HIPAA-aware tech support, patient communication tooling, telehealth integration, and donor systems for healthcare nonprofits, free clinics, community health organizations, and patient advocacy nonprofits.',
				'url' => 'https://csuitecode.com/nonprofit-it-support-healthcare/',
				'audience' => [ '@type' => 'MedicalAudience', 'audienceType' => 'Healthcare nonprofit organizations' ],
			] );

		case 288: // Nonprofits
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/nonprofits/#service',
				'name' => 'Technology Consulting for Nonprofits',
				'serviceType' => 'Nonprofit Technology Consulting',
				'description' => 'Discounted technology consulting for verified 501(c)(3) organizations, including websites, IT support, AI automation, managed cloud, and fractional tech leadership. Includes complimentary access to GrantMind Pro, an AI-powered grant research and writing platform.',
				'url' => 'https://csuitecode.com/nonprofits/',
				'audience' => [
					'@type' => 'Audience',
					'audienceType' => 'Nonprofit organizations (501(c)(3))',
				],
				'offers' => [
					'@type' => 'Offer',
					'description' => 'Discounted consulting rates and predictable monthly care for verified nonprofits, plus complimentary GrantMind Pro access ($249/month value).',
					'priceCurrency' => 'USD',
					'availability' => 'https://schema.org/InStock',
					'category' => 'Nonprofit consulting',
				],
				'isRelatedTo' => [
					'@type' => 'SoftwareApplication',
					'name' => 'GrantMind Pro',
					'url' => CSUITE_GRANTMIND,
					'applicationCategory' => 'BusinessApplication',
					'description' => 'AI-powered grant research and proposal writing platform for nonprofits, schools, municipalities, and grant-writing agencies.',
				],
			] );

		case 189: // Cloud Solutions
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/managed-cloud/#service',
				'name' => 'Managed Cloud Services & Migration',
				'serviceType' => 'Managed Cloud Services',
				'description' => 'Done-for-you managed cloud services for small businesses, including S3 migration, backups, disaster recovery, and cost optimization across AWS, Azure, and Google Cloud.',
				'url' => 'https://csuitecode.com/managed-cloud/',
			] );

		case 162: // AI for Your Business
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/ai/#service',
				'name' => 'AI Integration for Small Businesses',
				'serviceType' => 'AI Consulting and Automation',
				'description' => 'Practical AI integration for small and medium-sized businesses, including chatbots, document automation, workflow AI, and decision-support tools tailored to lean teams.',
				'url' => 'https://csuitecode.com/ai/',
			] );

		case 225: // Home Services AI Automation
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/services-ai-automation/#service',
				'name' => 'AI Automation for Home Service Businesses',
				'serviceType' => 'AI Automation for Home Services',
				'description' => 'AI-powered automation for HVAC, plumbing, cleaning, and other home service businesses - handling scheduling, invoicing, customer follow-up, and lead routing.',
				'url' => 'https://csuitecode.com/services-ai-automation/',
			] );

		case 61: // Pricing
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/pricing/#service',
				'name' => 'CSuite Code Service Pricing',
				'serviceType' => 'IT Consulting and Managed Services',
				'description' => 'Transparent pricing for managed IT, AI integrations, cloud services, and fractional CTO engagements tailored to small businesses and nonprofits.',
				'url' => 'https://csuitecode.com/pricing/',
			] );

		case 59: // Services hub
			return array_merge( $base, [
				'@id' => 'https://csuitecode.com/services/#service',
				'name' => 'CSuite Code Services',
				'serviceType' => 'Technology Consulting',
				'description' => 'Web development, IT support, AI automation, managed cloud, and fractional CTO services for small businesses and nonprofits.',
				'url' => 'https://csuitecode.com/services/',
			] );
	}

	return null;
}
