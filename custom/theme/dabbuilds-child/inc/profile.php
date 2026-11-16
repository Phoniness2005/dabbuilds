<?php
/**
 * Single source of truth for career facts shown on the site.
 *
 * Used by the home Experience snapshot, the About page, and the native
 * HTML resume. Truth rules (keep these when editing):
 * - Vermeer: production roles 2020 to 2022, IT Support Specialist I Feb 2022 to Apr 2024.
 * - SNHU B.A. is in progress, expected June 2027. Never imply it is complete.
 * - No pay figures. No on-call, travel, or overtime language.
 * - No contractions or em dashes in Daniel's copy.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Public contact points.
 *
 * @return array
 */
function dabbuilds_child_contact() {
	return array(
		'email'    => 'daniel@dabbuilds.com',
		'linkedin' => 'https://www.linkedin.com/in/daniel-bryant-34749943b',
		'github'   => 'https://github.com/Phoniness2005',
		'location' => 'Pella, Iowa',
	);
}

/**
 * The three "What I do" pillars. Only claims backed by Daniel's records.
 *
 * @return array
 */
function dabbuilds_child_pillars() {
	return array(
		array(
			'num'   => 'I',
			'title' => 'IT and Systems Support',
			'body'  => 'Three IT roles at Vermeer, Pella Technology, and Wells Fargo. Windows and Microsoft 365 support, SCCM application deployment, imaging and new computer setup, and Citrix user support.',
			'tags'  => array( 'SCCM', 'Windows', 'Microsoft 365', 'Imaging', 'Citrix' ),
		),
		array(
			'num'   => 'II',
			'title' => 'Security and Infrastructure',
			'body'  => 'Access reviews and compliance work in every IT role, Entra ID and Intune admin access at Wells Fargo, and a RAID license server I built at Vermeer for the 3DS engineering software.',
			'tags'  => array( 'Access reviews', 'Compliance', 'Entra ID', 'Intune' ),
		),
		array(
			'num'   => 'III',
			'title' => 'Making',
			'body'  => 'Army machinist and NTMA graduate. CNC setup and program editing, GD&T, and NIMS certification at work, plus CAD and 3D printing at home.',
			'tags'  => array( 'CNC', 'GD&T', 'NIMS', 'CAD', '3D printing' ),
		),
	);
}

/**
 * Experience, newest first. Dates only, no pay.
 *
 * @return array
 */
function dabbuilds_child_experience() {
	return array(
		array(
			'org'     => 'Emerson (Fisher Valves)',
			'role'    => 'Production Supervisor, Machining',
			'dates'   => 'Nov 2025 to Present',
			'place'   => 'Marshalltown, IA',
			'summary' => 'Lead a team of 14 CNC and manual machinists building custom control valve components.',
			'bullets' => array(
				'Direct daily operations and balance work for a team of 14 CNC and manual machinists producing custom control valve components.',
				'Run daily safety briefings and complete safety and quality audits.',
				'Train every new hire through machine qualification, and lead the shop-floor training revision committee.',
				'Work with production engineers on production and quality issues to reduce non-conformances, cost, and cycle time.',
				'Support 5S+1, TPM, and Kaizen work, and keep production records for efficiency, cross-training, and quality.',
			),
		),
		array(
			'org'     => 'Wells Fargo',
			'role'    => 'Technology Operations Analyst 1',
			'dates'   => 'Sep 2024 to Sep 2025',
			'place'   => 'Remote',
			'summary' => 'Entra ID and Intune admin access, incident documentation, and security compliance work.',
			'bullets' => array(
				'Monitored technology systems for availability, performance, and security, and handled routine maintenance.',
				'Worked incidents to resolution and documented them for future reference.',
				'Held Entra ID and Intune admin access for device and access work.',
				'Followed security policy, took part in audits and access reviews, and kept work in line with regulatory standards.',
			),
		),
		array(
			'org'     => 'Pella Technology',
			'role'    => 'IT Support Specialist',
			'dates'   => 'May 2024 to Sep 2024',
			'place'   => 'Pella, IA',
			'summary' => 'Managed service provider support for commercial clients.',
			'bullets' => array(
				'Set up new computers for commercial clients through Microsoft Azure managed deployment.',
				'Maintained Microsoft 365 for clients across multiple locations, including SharePoint sites and permissions.',
				'Moved client documentation from legacy systems into IT Glue.',
				'Installed and supported VOIP phone systems and email security through Proofpoint.',
			),
		),
		array(
			'org'     => 'Vermeer',
			'role'    => 'IT Support Specialist I',
			'dates'   => 'Feb 2022 to Apr 2024',
			'place'   => 'Pella, IA',
			'summary' => 'Service desk and in-person support across the Pella and Des Moines campuses.',
			'bullets' => array(
				'Worked support requests through ITOP, phone, and Microsoft Teams, and supported users in person across the Pella and Des Moines campuses.',
				'Managed Okta access, Zoom, licenses, and device inventory, including onboarding and offboarding equipment.',
				'Supported the SigmaNest 2023 install and license server update, and the MasterCam 2023 license renewal.',
				'Built the 3DS license server with a RAID configuration that alerts IT Operations if a drive fails.',
			),
		),
		array(
			'org'     => 'Vermeer',
			'role'    => 'Machining Specialist, then Plant 2 Plate Side Group Leader',
			'dates'   => '2020 to 2022',
			'place'   => 'Pella, IA',
			'summary' => 'CNC lathes and mills, then led the plate side of the Plant 2 machine shop.',
			'bullets' => array(
				'Set up and edited programs on Mori Seiki CNC lathes and mills, machining heavy duty drilling rods and adapters from heat-treated steel.',
				'Led daily operation of two lasers, two folders, two benders, laser programming, and the robotic weld cell.',
				'Coordinated daily production with welding, assembly, and inventory group leaders across Plant 2.',
			),
		),
		array(
			'org'     => 'U.S. Army',
			'role'    => 'Allied Trades Specialist (91E Machinist)',
			'dates'   => '2009 to 2014',
			'place'   => 'Fort Irwin, CA; Afghanistan; Camp Humphreys, Korea',
			'summary' => 'Fabricated and repaired parts on lathes and mills from provided specifications.',
			'bullets' => array(
				'Fabricated and repaired metallic and nonmetallic parts using lathes, milling machines, and hand tools.',
				'Accountable for the receipt, inventory, and readiness of general and specialty tool sets.',
				'Selected as Standard Bearer for the Battalion Honor Guard.',
			),
		),
	);
}

/**
 * Earlier roles, one line each.
 *
 * @return array
 */
function dabbuilds_child_earlier_roles() {
	return array(
		'Strength and Conditioning Coach, CrossFit SBC, Shreveport, LA (2019 to 2020)',
		'Schedule II Production Technician, Dr. Reddy\'s Laboratories, Shreveport, LA (2017 to 2018)',
		'Exercise Specialist, Christus Louisiana Athletic Clubs, Bossier City, LA (2015 to 2017)',
		'Spacecraft Assembly Technician Intern, SpaceX, Hawthorne, CA (2014)',
	);
}

/**
 * Education. SNHU is in progress.
 *
 * @return array
 */
function dabbuilds_child_education() {
	return array(
		array(
			'school' => 'Southern New Hampshire University',
			'detail' => 'B.A., General Studies, Mathematics concentration',
			'dates'  => 'In progress, expected June 2027',
		),
		array(
			'school' => 'NTMA Training Centers',
			'detail' => 'Machinist Training Graduate, 905-hour program, 4.0 GPA, Honor Graduate',
			'dates'  => '2014',
		),
	);
}

/**
 * Certifications and training (from the resume on file).
 *
 * @return array
 */
function dabbuilds_child_certifications() {
	return array(
		'CompTIA ITF+',
		'Kaseya Certified Technician, Datto RMM',
		'Dell PowerEdge Corrective Maintenance; Dell Client Foundations 2021; Dell Enterprise Self-Dispatch',
		'IBM Technical Support Capstone, plus IBM coursework in cybersecurity, networking and storage, and operating systems',
		'Palantir Foundry and AIP Builder Foundations',
		'NIMS Metalworking Skills Certification: Measurement, Materials, and Safety',
	);
}

/**
 * Skills grouped for the resume. Only skills Daniel's records back.
 *
 * @return array
 */
function dabbuilds_child_skills() {
	return array(
		'IT'     => array( 'User support', 'Windows', 'Microsoft 365', 'SCCM', 'Imaging', 'Citrix user support', 'Entra ID', 'Intune', 'Okta', 'SharePoint' ),
		'Making' => array( 'CNC setup and program editing', 'GD&T', 'NIMS', 'CAD (hobby)', '3D printing' ),
	);
}
