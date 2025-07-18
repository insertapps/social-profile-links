<?php
/**
 * Display social media profile links.
 *
 * @param int $user_id User ID to display social links for.
 * @return string HTML content for social media links.
 */
function display_social_links( $user_id ) {
	// Set icon size dengan filter
	$icon_size = apply_filters( 'social_links_icon_size', 50 );

	// Platform default links
	$default_platforms = array(
		'website'   => get_the_author_meta( 'user_url', $user_id ),
		'facebook'  => get_user_meta( $user_id, 'facebook', true ),
		'twitter'   => get_user_meta( $user_id, 'twitter', true ),
		'linkedin'  => get_user_meta( $user_id, 'linkedin', true ),
		'instagram' => get_user_meta( $user_id, 'instagram', true ),
		'youtube'   => get_user_meta( $user_id, 'youtube', true ),
		'tiktok'    => get_user_meta( $user_id, 'tiktok', true ),
		'donate'    => get_user_meta( $user_id, 'donate', true ),
		'linktree'  => get_user_meta( $user_id, 'linktree', true ),
	);

	// Filter to allow custom platforms
	$platforms = apply_filters( 'social_profile_links_platforms', $default_platforms, $user_id );

	// Validasi URL
	$social_links = array();
	foreach ( $platforms as $platform => $url ) {
		$validated_url = filter_var( esc_url_raw( $url ), FILTER_VALIDATE_URL );
		if ( $validated_url ) {
			$social_links[$platform] = $validated_url;
		}
	}

	// Generate HTML
	$html = '<ul class="spl-container">';
	foreach ( $social_links as $platform => $link ) {
		$icon_path = apply_filters( 
			'social_profile_links_icon_path', 
			plugin_dir_url( __FILE__ ) . '../assets/icons/' . esc_attr( $platform ) . '.svg',
			$platform
		);
		
		$html .= '<li>';
		$html .= '<a class="spl-link" href="' . esc_url( $link ) . '" target="_blank" rel="noopener noreferrer">';
		$html .= '<img class="spl-img" 
					   src="' . esc_url( $icon_path ) . '" 
					   alt="' . esc_attr( $platform ) . '" 
					   title="' . esc_attr( ucwords( $platform ) ) . '" 
					   width="' . $icon_size . '" 
					   height="' . $icon_size . '" 
					   loading="lazy" 
					   decoding="async">';
		$html .= '</a>';
		$html .= '</li>';
	}
	$html .= '</ul>';

	return $html; 
}