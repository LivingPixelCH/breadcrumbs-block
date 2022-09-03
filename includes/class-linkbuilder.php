<?php
/**
 * Class LinkBuilder
 *
 * Returns a formated Link.
 *
 * @package breadcrumbs-block
 * @author Daniel Von Rohr <info@livingpixel.ch>
 */

namespace BreadcrumbsBlock;

class LinkBuilder
{
	public function __construct()
	{
		$this->structure = '<a href="%s">%s</a>';
	}

	public function create($url, $text)
	{
		return sprintf($this->structure, $url, $text);
	}
}
