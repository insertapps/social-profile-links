<?php
/**
 * Uninstall script for the Social Profile Links plugin.
 *
 * This script is executed when the plugin is uninstalled.
 * It removes all user meta data related to social profile links.
 *
 * @package Social_Profile_Links
 */

// If this file is called directly, abort.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

// Get all users default platforms to remove
$default_methods = array(
	'facebook'  => '',
	'twitter'   => '',
	'linkedin'  => '',
	'instagram' => '',
	'youtube'   => '',
	'tiktok'    => '',
	'donate'    => '',
	'linktree'  => '',
	'website'   => '',
);

// Get custom platforms from filter
$platforms = apply_filters( 'social_profile_links_platforms', $default_methods );
$fields = array_keys( $platforms );

$offset = 0;
$limit = 69;

do {
	$users = get_users([
		'number' => $limit,
		'offset' => $offset,
		'fields' => ['ID']
	]);

	foreach ($users as $user) {
		foreach ($fields as $field) {
			delete_user_meta($user->ID, $field);
		}
	}

	$offset += $limit;
} while (count($users) === $limit);