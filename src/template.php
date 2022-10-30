<?php
namespace BreadcrumbsBlock;

use BreadcrumbsBlock\Breadcrumb;

$breadcrumbs = new Breadcrumb();

$alignment_class = null !== $attributes['textAlignment'] ? 'has-text-align-' . $attributes['textAlignment'] : '';
?>

<div <?php echo get_block_wrapper_attributes([
	'class' => $alignment_class,
]); ?>>
	<?php esc_html( $breadcrumbs->render() ); ?>
</div>
