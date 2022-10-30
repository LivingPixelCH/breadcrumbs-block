<?php
namespace BreadcrumbsBlock;

use BreadcrumbsBlock\Breadcrumb;

$separator = '';

if ( array_key_exists( 'separator', $attributes ) ) {
	$separator = $attributes['separator'];
}

$breadcrumbs = new Breadcrumb( 'Home', $separator );

$alignment_class = '';

if ( array_key_exists( 'textAlignment', $attributes ) ) {
	$alignment_class = 'has-text-align-' . $attributes['textAlignment'];
}

?>

<div <?php echo get_block_wrapper_attributes([
	'class' => $alignment_class,
]); ?>>
	<?php esc_html( $breadcrumbs->render() ); ?>
</div>
