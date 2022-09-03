<?php
/**
 * Adds a breadcrumb item to the trail of the page.
 *
 * @package breadcrumbs-block
 * @author Daniel Von Rohr <info@livingpixel.ch>
 */

namespace BreadcrumbsBlock;

class Trail
{
	public function __construct($delimiter)
	{
		$this->delimiter = $delimiter;
		$this->trail = [];
	}

	public function add($value)
	{
		$this->trail[] = $value;
	}

	public function render()
	{
		return implode('<span class="delimiter">' . $this->delimiter . '</span>', $this->trail);
	}
}
