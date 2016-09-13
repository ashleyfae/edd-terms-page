<?php
/*
 * Plugin Name: EDD Terms Page
 * Plugin URI: https://www.nosegraze.com
 * Description: Choose a page to use for your terms. The page content is loaded into the checkout page.
 * Version: 1.0
 * Author: Nose Graze
 * Author URI: https://www.nosegraze.com
 * License: GPL2
 * 
 * @package edd-terms-page
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license GPL2+
*/

/**
 * Add Settings
 *
 * @param array $settings
 *
 * @since 1.0
 * @return array
 */
function edd_terms_page_addon_settings( $settings ) {
	$settings['site_terms']['terms_page'] = array(
		'id'          => 'terms_page',
		'name'        => __( 'Terms Page', 'edd-terms-page' ),
		'desc'        => __( 'Choose a page to use for your terms and conditions. The contents of this page will be loaded into the "Agreement Text" on checkout.', 'edd-terms-page' ),
		'type'        => 'select',
		'options'     => edd_get_pages(),
		'placeholder' => __( 'Select a Page', 'edd-terms-page' )
	);

	return $settings;
}

add_filter( 'edd_settings_misc', 'edd_terms_page_addon_settings' );

/**
 * Display the page contents.
 *
 * @since 1.0
 * @return void
 */
function edd_terms_page_addon_content() {
	$terms_page_id = edd_get_option( 'terms_page', false );

	if ( empty( $terms_page_id ) || ! is_numeric( $terms_page_id ) ) {
		return;
	}

	$terms_page = get_post( $terms_page_id );

	if ( ! is_a( $terms_page, 'WP_Post' ) ) {
		return;
	}

	echo apply_filters( 'edd_terms_page_terms_content', $terms_page->post_content );
}

add_action( 'edd_after_terms', 'edd_terms_page_addon_content' );

/**
 * Add filters to terms content.
 */
add_filter( 'edd_terms_page_terms_content', 'wptexturize' );
add_filter( 'edd_terms_page_terms_content', 'wpautop' );