<?php
/**
 * Fixed loop ceilings for the child theme.
 *
 * Power of 10 rule 2. Each value is a literal a reviewer can check.
 * Rendering loops stop at these caps; current copy is under every cap.
 *
 * @package dabbuilds-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Statically proven iteration ceilings.
 */
final class Dabbuilds_Child_Bounds {
	public const LOG_ROWS     = 100;
	public const NAV          = 8;
	public const PILLARS      = 8;
	public const WORK         = 12;
	public const TAGS         = 32;
	public const JOBS         = 12;
	public const BULLETS      = 16;
	public const EARLIER      = 16;
	public const EDUCATION    = 8;
	public const CERTS        = 32;
	public const CREDENTIALS  = 16;
	public const CREDENTIALS_HOME = 8;
	public const SKILL_GROUPS = 8;
	public const SKILLS       = 24;
	public const ROUTES       = 8;
	public const CLASSES      = 128;
	public const HINTS        = 32;
	public const SINGULAR     = 20;
}
