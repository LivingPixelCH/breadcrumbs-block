<?php
namespace BreadcrumbsBlock;

use BreadcrumbsBlock\Breadcrumb;

$breadcrumbs = new Breadcrumb();
?>

<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php esc_html($breadcrumbs->render()); ?>
</p>
