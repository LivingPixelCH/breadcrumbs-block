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
	private string $delimiter;

	public function __construct($delimiter)
	{
		$this->delimiter = $delimiter;
		$this->structure = '<a href="%s">%s</a>%s';
	}

	public function create($url, $text)
	{
		return sprintf($this->structure, $url, $text, $this->delimiter);
	}
}
