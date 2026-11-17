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
 * - No home city, and the public contact address is jobs@dabbuilds.com.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Keep a job record only when the required fields are the expected types.
 *
 * @param mixed $job Job record.
 * @return array<string, mixed>
 */
function dabbuilds_child_freeze_job( $job ) {
	if ( ! is_array( $job ) ) {
		return array();
	}
	foreach ( array( 'org', 'role', 'dates', 'place', 'summary', 'bullets' ) as $key ) {
		if ( ! isset( $job[ $key ] ) ) {
			return array();
		}
	}
	if ( ! is_string( $job['org'] ) || ! is_string( $job['role'] ) || ! is_string( $job['dates'] ) ) {
		return array();
	}
	if ( ! is_string( $job['place'] ) || ! is_string( $job['summary'] ) || ! is_array( $job['bullets'] ) ) {
		return array();
	}
	$bullets = array();
	$count   = 0;
	foreach ( $job['bullets'] as $bullet ) {
		if ( $count >= Dabbuilds_Child_Bounds::BULLETS ) {
			break;
		}
		++$count;
		if ( ! is_string( $bullet ) ) {
			return array();
		}
		$bullets[] = $bullet;
	}
	if ( count( $bullets ) < 1 ) {
		return array();
	}
	return array(
		'org'     => $job['org'],
		'role'    => $job['role'],
		'dates'   => $job['dates'],
		'place'   => $job['place'],
		'summary' => $job['summary'],
		'bullets' => $bullets,
	);
}

/**
 * Public contact points. No home location is published.
 *
 * @return array{email: string, linkedin: string, github: string}
 */
function dabbuilds_child_contact() {
	$contact = array(
		'email'    => 'jobs@dabbuilds.com',
		'linkedin' => 'https://www.linkedin.com/in/daniel-bryant-34749943b',
		'github'   => 'https://github.com/Phoniness2005',
	);
	return $contact;
}

/**
 * The three "What I do" pillars. Only claims backed by Daniel's records.
 *
 * @return list<array<string, mixed>>
 */
function dabbuilds_child_pillars() {
	$pillars = array(
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
	return $pillars;
}

/**
 * Emerson role.
 *
 * @return array<string, mixed>
 */
function dabbuilds_child_job_emerson() {
	return dabbuilds_child_freeze_job(
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
		)
	);
}

/**
 * Wells Fargo role.
 *
 * @return array<string, mixed>
 */
function dabbuilds_child_job_wells_fargo() {
	return dabbuilds_child_freeze_job(
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
		)
	);
}

/**
 * Pella Technology role. The employer name stays; the city does not.
 *
 * @return array<string, mixed>
 */
function dabbuilds_child_job_pella() {
	return dabbuilds_child_freeze_job(
		array(
			'org'     => 'Pella Technology',
			'role'    => 'IT Support Specialist',
			'dates'   => 'May 2024 to Sep 2024',
			'place'   => '',
			'summary' => 'Managed service provider support for commercial clients.',
			'bullets' => array(
				'Set up new computers for commercial clients through Microsoft Azure managed deployment.',
				'Maintained Microsoft 365 for clients across multiple locations, including SharePoint sites and permissions.',
				'Moved client documentation from legacy systems into IT Glue.',
				'Installed and supported VOIP phone systems and email security through Proofpoint.',
			),
		)
	);
}

/**
 * Vermeer IT role.
 *
 * @return array<string, mixed>
 */
function dabbuilds_child_job_vermeer_it() {
	return dabbuilds_child_freeze_job(
		array(
			'org'     => 'Vermeer',
			'role'    => 'IT Support Specialist I',
			'dates'   => 'Feb 2022 to Apr 2024',
			'place'   => '',
			'summary' => 'Service desk and in-person support across the company campuses.',
			'bullets' => array(
				'Worked support requests through ITOP, phone, and Microsoft Teams, and supported users in person across the company campuses.',
				'Managed Okta access, Zoom, licenses, and device inventory, including onboarding and offboarding equipment.',
				'Supported the SigmaNest 2023 install and license server update, and the MasterCam 2023 license renewal.',
				'Built the 3DS license server with a RAID configuration that alerts IT Operations if a drive fails.',
			),
		)
	);
}

/**
 * Vermeer machining role.
 *
 * @return array<string, mixed>
 */
function dabbuilds_child_job_vermeer_shop() {
	return dabbuilds_child_freeze_job(
		array(
			'org'     => 'Vermeer',
			'role'    => 'Machining Specialist, then Plant 2 Plate Side Group Leader',
			'dates'   => '2020 to 2022',
			'place'   => '',
			'summary' => 'CNC lathes and mills, then led the plate side of the Plant 2 machine shop.',
			'bullets' => array(
				'Set up and edited programs on Mori Seiki CNC lathes and mills, machining heavy duty drilling rods and adapters from heat-treated steel.',
				'Led daily operation of two lasers, two folders, two benders, laser programming, and the robotic weld cell.',
				'Coordinated daily production with welding, assembly, and inventory group leaders across Plant 2.',
			),
		)
	);
}

/**
 * Army role.
 *
 * @return array<string, mixed>
 */
function dabbuilds_child_job_army() {
	return dabbuilds_child_freeze_job(
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
		)
	);
}

/**
 * Experience, newest first. Dates only, no pay.
 *
 * @return list<array<string, mixed>>
 */
function dabbuilds_child_experience() {
	$jobs  = array(
		dabbuilds_child_job_emerson(),
		dabbuilds_child_job_wells_fargo(),
		dabbuilds_child_job_pella(),
		dabbuilds_child_job_vermeer_it(),
		dabbuilds_child_job_vermeer_shop(),
		dabbuilds_child_job_army(),
	);
	$clean = array();
	foreach ( $jobs as $job ) {
		if ( ! isset( $job['org'] ) || ! is_string( $job['org'] ) || '' === $job['org'] ) {
			continue;
		}
		if ( ! isset( $job['bullets'] ) || ! is_array( $job['bullets'] ) ) {
			continue;
		}
		$clean[] = $job;
	}
	return $clean;
}

/**
 * Earlier roles, one line each.
 *
 * @return list<string>
 */
function dabbuilds_child_earlier_roles() {
	$roles = array(
		'Strength and Conditioning Coach, CrossFit SBC, Shreveport, LA (2019 to 2020)',
		'Schedule II Production Technician, Dr. Reddy\'s Laboratories, Shreveport, LA (2017 to 2018)',
		'Exercise Specialist, Christus Louisiana Athletic Clubs, Bossier City, LA (2015 to 2017)',
		'Spacecraft Assembly Technician Intern, SpaceX, Hawthorne, CA (2014)',
	);
	return $roles;
}

/**
 * Education. SNHU is in progress.
 *
 * @return list<array<string, mixed>>
 */
function dabbuilds_child_education() {
	$rows = array(
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
	return $rows;
}

/**
 * Certifications and training (from the resume on file).
 *
 * @return list<string>
 */
function dabbuilds_child_certifications() {
	$certs = array(
		'CompTIA ITF+',
		'Kaseya Certified Technician, Datto RMM',
		'Dell PowerEdge Corrective Maintenance; Dell Client Foundations 2021; Dell Enterprise Self-Dispatch',
		'IBM Technical Support Capstone, plus IBM coursework in cybersecurity, networking and storage, and operating systems',
		'Palantir Foundry and AIP Builder Foundations',
		'NIMS Metalworking Skills Certification: Measurement, Materials, and Safety',
	);
	return $certs;
}

/**
 * Skills grouped for the resume. Only skills Daniel's records back.
 *
 * @return array<string, list<string>>
 */
function dabbuilds_child_skills() {
	$skills = array(
		'IT'     => array( 'User support', 'Windows', 'Microsoft 365', 'SCCM', 'Imaging', 'Citrix user support', 'Entra ID', 'Intune', 'Okta', 'SharePoint' ),
		'Making' => array( 'CNC setup and program editing', 'GD&T', 'NIMS', 'CAD (hobby)', '3D printing' ),
	);
	return $skills;
}
