<?php
/**
 * Plugin Name:       LivingPixel - Breadcrumbs Block
 * Description:       Display a breadcrumb trail on your website with Gutenberg.
 * Requires at least: 5.9
 * Requires PHP:      7.2
 * Version:           0.9.0
 * Author:            Daniel von Rohr <info@livingpixel.ch>
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       livingpixel-breadcrumbs-block
 *
 * @package           livingpixel-breadcrumbs-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_breadcrumbs_block_block_init() {
	register_block_type(
		__DIR__ . '/build',
		array(
			'render_callback' => 'create_block_breadcrumbs_block_render_callback',
		)
	);
}
add_action( 'init', 'create_block_breadcrumbs_block_block_init' );

/**
 * Render callback function.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The block content.
 * @param WP_Block $block      Block instance.
 *
 * @return string The rendered output.
 */
function create_block_breadcrumbs_block_render_callback( $attributes, $content, $block ) {
	include_once 'includes/class-breadcrumb.php';
	include_once 'includes/class-linkbuilder.php';
	include_once 'includes/class-trail.php';

	ob_start();
	require plugin_dir_path( __FILE__ ) . 'build/template.php';
	return ob_get_clean();
}
