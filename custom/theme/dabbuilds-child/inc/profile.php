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
		'linkedin' => 'https://www.linkedin.com/in/daniel-a-bryant',
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
 * Public Credly profile.
 *
 * @return string
 */
function dabbuilds_child_credly_url() {
	return 'https://www.credly.com/users/daniel-bryant.6c63c37c';
}

/**
 * Keep a credential record only when the required fields are valid.
 *
 * @param mixed $row Credential record.
 * @return array<string, string>
 */
function dabbuilds_child_freeze_credential( $row ) {
	if ( ! is_array( $row ) ) {
		return array();
	}
	foreach ( array( 'name', 'issuer', 'year', 'image', 'url' ) as $key ) {
		if ( ! isset( $row[ $key ] ) || ! is_string( $row[ $key ] ) || '' === $row[ $key ] ) {
			return array();
		}
	}
	if ( 1 !== preg_match( '/^[a-z0-9][a-z0-9.-]{0,120}\.png$/', $row['image'] ) ) {
		return array();
	}
	if ( 1 !== preg_match( '/^https:\/\/www\.credly\.com\/badges\/[a-f0-9-]{36}$/', $row['url'] ) ) {
		return array();
	}
	if ( 1 !== preg_match( '/^20[0-9]{2}$/', $row['year'] ) ) {
		return array();
	}
	return array(
		'name'   => $row['name'],
		'issuer' => $row['issuer'],
		'year'   => $row['year'],
		'image'  => $row['image'],
		'url'    => $row['url'],
	);
}

/**
 * Theme URI for a self-hosted badge PNG. Rejects anything but a plain filename.
 *
 * @param string $image Filename under assets/badges/.
 * @return string
 */
function dabbuilds_child_credential_image_url( $image ) {
	if ( ! is_string( $image ) || 1 !== preg_match( '/^[a-z0-9][a-z0-9.-]{0,120}\.png$/', $image ) ) {
		return '';
	}
	return get_stylesheet_directory_uri() . '/assets/badges/' . $image;
}

/**
 * CompTIA, then the first IBM IT-track badges.
 *
 * @return list<array<string, string>>
 */
function dabbuilds_child_credential_rows_it() {
	return array(
		array(
			'name'   => 'CompTIA IT Fundamentals+ (ITF+) Certification',
			'issuer' => 'CompTIA',
			'year'   => '2024',
			'image'  => 'comptia-it-fundamentals-itf-certification-581bc9bc.png',
			'url'    => 'https://www.credly.com/badges/581bc9bc-492a-42cf-9ba9-9ebcccc44cf6',
		),
		array(
			'name'   => 'Introduction to Cloud Computing',
			'issuer' => 'IBM',
			'year'   => '2023',
			'image'  => 'introduction-to-cloud-computing-76d108a7.png',
			'url'    => 'https://www.credly.com/badges/76d108a7-c98e-42ab-b9e4-f0391cf87c24',
		),
		array(
			'name'   => 'Technical Support Capstone',
			'issuer' => 'IBM',
			'year'   => '2023',
			'image'  => 'technical-support-capstone-5d2fff93.png',
			'url'    => 'https://www.credly.com/badges/5d2fff93-a824-4a29-9de0-f030bcb0c0f0',
		),
		array(
			'name'   => 'Cybersecurity Essentials',
			'issuer' => 'IBM',
			'year'   => '2023',
			'image'  => 'cybersecurity-essentials-78b556b4.png',
			'url'    => 'https://www.credly.com/badges/78b556b4-1528-4d20-8ff3-aa5fe733d54f',
		),
	);
}

/**
 * Remaining IBM IT and technical support badges, newest first.
 *
 * @return list<array<string, string>>
 */
function dabbuilds_child_credential_rows_it_more() {
	return array(
		array(
			'name'   => 'Networking and Storage Essentials',
			'issuer' => 'IBM',
			'year'   => '2023',
			'image'  => 'networking-and-storage-essentials-ee6d7413.png',
			'url'    => 'https://www.credly.com/badges/ee6d7413-b897-46cc-92cf-488f435b179e',
		),
		array(
			'name'   => 'Software, Programming, and Database Essentials',
			'issuer' => 'IBM',
			'year'   => '2023',
			'image'  => 'software-programming-and-database-essentials-7d25888b.png',
			'url'    => 'https://www.credly.com/badges/7d25888b-3131-4643-ab42-326a74133193',
		),
		array(
			'name'   => 'Hardware and Operating System Essentials',
			'issuer' => 'IBM',
			'year'   => '2023',
			'image'  => 'hardware-and-operating-system-essentials-2a75a334.png',
			'url'    => 'https://www.credly.com/badges/2a75a334-7a4d-49ea-96c0-6b54381ba2ce',
		),
		array(
			'name'   => 'Technical Support Basics',
			'issuer' => 'IBM',
			'year'   => '2023',
			'image'  => 'technical-support-basics-c68aca82.png',
			'url'    => 'https://www.credly.com/badges/c68aca82-a61d-45fc-a334-bbb3a5f61c04',
		),
	);
}

/**
 * IBM cybersecurity course badges, newest first.
 *
 * @return list<array<string, string>>
 */
function dabbuilds_child_credential_rows_cyber() {
	return array(
		array(
			'name'   => 'Cybersecurity Compliance Framework & System Administration',
			'issuer' => 'IBM',
			'year'   => '2023',
			'image'  => 'cybersecurity-compliance-framework-system-administration-2b34a778.png',
			'url'    => 'https://www.credly.com/badges/2b34a778-e0f3-470e-b5cb-4728d8b3d00e',
		),
		array(
			'name'   => 'Cybersecurity Roles, Processes & Operating System Security',
			'issuer' => 'IBM',
			'year'   => '2022',
			'image'  => 'cybersecurity-roles-processes-operating-system-security-34f7594c.png',
			'url'    => 'https://www.credly.com/badges/34f7594c-99c0-4cf1-a8a2-7096e77daf51',
		),
		array(
			'name'   => 'Introduction to Cybersecurity Tools & Cyber Attacks',
			'issuer' => 'IBM',
			'year'   => '2022',
			'image'  => 'introduction-to-cybersecurity-tools-cyber-attacks-95c26118.png',
			'url'    => 'https://www.credly.com/badges/95c26118-0bb0-4247-b0f0-a25caf38a023',
		),
	);
}

/**
 * IBM data science course badges, newest first.
 *
 * @return list<array<string, string>>
 */
function dabbuilds_child_credential_rows_data() {
	return array(
		array(
			'name'   => 'Data Visualization with Python',
			'issuer' => 'IBM',
			'year'   => '2022',
			'image'  => 'data-visualization-with-python-af5a9454.png',
			'url'    => 'https://www.credly.com/badges/af5a9454-5e08-402d-9370-27a798f6b11c',
		),
		array(
			'name'   => 'Data Analysis with Python',
			'issuer' => 'IBM',
			'year'   => '2022',
			'image'  => 'data-analysis-with-python-9f026389.png',
			'url'    => 'https://www.credly.com/badges/9f026389-eaba-473e-954a-12283e7d71eb',
		),
		array(
			'name'   => 'Data Science Methodology',
			'issuer' => 'IBM',
			'year'   => '2022',
			'image'  => 'data-science-methodology-e2005cee.png',
			'url'    => 'https://www.credly.com/badges/e2005cee-c0a6-4cb9-921e-742f0c7b0195',
		),
		array(
			'name'   => 'Tools for Data Science',
			'issuer' => 'IBM',
			'year'   => '2022',
			'image'  => 'tools-for-data-science-bd0511d8.png',
			'url'    => 'https://www.credly.com/badges/bd0511d8-8d08-4e1c-b12e-b70fe2d1c36d',
		),
		array(
			'name'   => 'Data Science Orientation',
			'issuer' => 'IBM',
			'year'   => '2022',
			'image'  => 'data-science-orientation-e9b2b197.png',
			'url'    => 'https://www.credly.com/badges/e9b2b197-ef86-483f-b2cb-a5fd1e3d1ac8',
		),
	);
}

/**
 * Credly badges, in site order. CompTIA first, then IBM tracks.
 *
 * @return list<array<string, string>>
 */
function dabbuilds_child_credentials() {
	$clean = array();
	$n     = 0;
	$rows  = array_merge(
		dabbuilds_child_credential_rows_it(),
		dabbuilds_child_credential_rows_it_more(),
		dabbuilds_child_credential_rows_cyber(),
		dabbuilds_child_credential_rows_data()
	);
	foreach ( $rows as $row ) {
		if ( $n >= Dabbuilds_Child_Bounds::CREDENTIALS ) {
			break;
		}
		++$n;
		$frozen = dabbuilds_child_freeze_credential( $row );
		if ( ! isset( $frozen['name'] ) ) {
			continue;
		}
		$clean[] = $frozen;
	}
	return $clean;
}

/**
 * Training that is not on the public Credly profile.
 *
 * @return list<string>
 */
function dabbuilds_child_other_certifications() {
	return array(
		'Kaseya Certified Technician, Datto RMM',
		'Dell PowerEdge Corrective Maintenance; Dell Client Foundations 2021; Dell Enterprise Self-Dispatch',
		'Palantir Foundry and AIP Builder Foundations',
		'NIMS Metalworking Skills Certification: Measurement, Materials, and Safety',
	);
}

/**
 * Certifications for the résumé: Credly badges as "name, issuer, year", then other training.
 *
 * @return list<string>
 */
function dabbuilds_child_certifications() {
	$lines = array();
	$n     = 0;
	foreach ( dabbuilds_child_credentials() as $cred ) {
		if ( $n >= Dabbuilds_Child_Bounds::CERTS ) {
			break;
		}
		++$n;
		$lines[] = $cred['name'] . ', ' . $cred['issuer'] . ', ' . $cred['year'];
	}
	foreach ( dabbuilds_child_other_certifications() as $other ) {
		if ( $n >= Dabbuilds_Child_Bounds::CERTS ) {
			break;
		}
		++$n;
		if ( ! is_string( $other ) ) {
			continue;
		}
		$lines[] = $other;
	}
	return $lines;
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
