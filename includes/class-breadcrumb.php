<?php
/**
 * Class Breadcrumb
 *
 * Creates a breadcrumb navigation for the current active page.
 *
 * @package breadcrumbs-block
 * @author Daniel Von Rohr <info@livingpixel.ch>
 */

namespace BreadcrumbsBlock;

class Breadcrumb {

	private string $home;

	private string $delimiter;

	function __construct( $home = 'Home', $delimiter = '&raquo;' ) {
		$this->home               = $home;
		$this->delimiter          = $delimiter;
		$this->current_class_name = 'current-page';

		$this->trail       = new Trail( $this->delimiter );
		$this->linkBuilder = new LinkBuilder();
	}

	private function appendToTrail( $text, $current = false ) {
		if ( $current ) {
			$text = sprintf( '<span class="%s">%s</span>', $this->current_class_name, $text );
		}
		$this->trail->add( $text );
	}

	private function appendLinkToTrail( $text, $url ) {
		$link = $this->linkBuilder->create( $url, $text );

		$this->trail->add( $link );
	}

	private function pageIsCategory() {
		 global $wp_query;

		$category = $wp_query->get_queried_object()->term_id;

		if ( $category->parent ) {
			$parent_category = get_category( $category->parent );
			$text            = get_category_parents( $parent_category, true, ' ', $this->delimiter );

			$this->appendToTrail( $text );
			$this->appendToTrail( single_cat_title( '', false ), true );
		}
	}

	private function pageIsDay() {
		$this->appendLinkToTrail( get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) );
		$this->appendLinkToTrail( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) );
		$this->appendToTrail( get_the_time( 'd' ), true );
	}

	private function pageIsMonth() {
		$this->appendLinkToTrail( get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) );
		$this->appendToTrail( get_the_time( 'F' ), true );
	}

	private function pageIsYear() {
		 $this->appendToTrail( get_the_time( 'Y' ), true );
	}

	private function pageIsSingleWithoutAttachment() {
		if ( get_post_type() !== 'post' ) {
			$post_type = get_post_type_object( get_post_type() );
			$slug      = $post_type->rewrite;
			$this->appendLinkToTrail( $post_type->labels->singular_name, get_bloginfo( 'url' ) . '/' . $slug['slug'] . '/' );
			$this->appendToTrail( get_the_title(), true );
		} else {
			$category = get_the_category();
			$category = $category[0];
			$this->appendToTrail( get_category_parents( $category, true, ' ' . $this->delimiter . ' ' ) );
			$this->appendToTrail( get_the_title(), true );
		}
	}

	private function pageIsIndex() {
		$post_type = get_post_type_object( get_post_type() );
		$this->appendToTrail( $post_type->labels->singular_name, true );
	}

	private function pageIsAttachment() {
		global $post;

		$parent   = get_post( $post->post_parent );
		$category = get_the_category( $parent->ID );
		$category = $category[0];
		$this->appendToTrail( get_category_parents( $category, true, ' ' . $this->delimiter . ' ' ) );
		$this->appendLinkToTrail( get_permalink( $parent ), $parent->post_title );
		$this->appendToTrail( get_the_title(), true );
	}

	private function pageIsPageWithoutParent() {
		$this->appendToTrail( get_the_title(), true );
	}

	private function pageIsPageWithParent() {
		global $post;

		$parent_id   = $post->post_parent;
		$breadcrumbs = array();

		while ( $parent_id ) {
			$page          = get_post( $parent_id );
			$breadcrumbs[] = array(
				'url'  => get_permalink( $page->ID ),
				'text' => get_the_title( $page->ID ),
			);
			$parent_id     = $page->post_parent;
		}

		foreach ( array_reverse( $breadcrumbs ) as $crumb ) {
			$this->appendLinkToTrail( $crumb['text'], $crumb['url'] );
		}

		$this->appendToTrail( get_the_title(), true );
	}

	private function pageIsSearch() {
		$this->appendToTrail( __( 'Results for your search for' ) . ' ' . get_search_query(), true );
	}

	private function pageIsTag() {
		$this->appendToTrail( __( 'Posts tagged' ) . ' ' . single_tag_title( '', false ), true );
	}

	private function pageIs404() {
		$this->appendToTrail( __( 'Error 404' ), true );
	}

	private function pageIsPaged() {
		$text = '';

		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
			$text .= '(';
		}

		$text .= ': ' . __( 'Page' ) . ' ' . get_query_var( 'paged' );

		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
			$text .= ')';
		}

		$this->appendToTrail( $text );
	}

	public function render() {
		global $post;

		if ( is_home() && is_front_page() || ! is_paged() ) {
			// return;
		}

		if ( ! empty( $this->home ) ) {
			$this->appendLinkToTrail( $this->home, get_bloginfo( 'url' ) );
		}

		if ( is_category() ) {
			$this->pageIsCategory();
		}

		if ( is_day() ) {
			$this->pageIsDay();
		}

		if ( is_month() ) {
			$this->pageIsMonth();
		}

		if ( is_year() ) {
			$this->pageIsYear();
		}

		if ( is_single() && ! is_attachment() ) {
			$this->pageIsSingleWithoutAttachment();
		}

		if ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
			$this->pageIsIndex();
		}

		if ( is_attachment() ) {
			$this->pageIsAttachment();
		}

		if ( is_page() && ! $post->post_parent ) {
			$this->pageIsPageWithoutParent();
		}

		if ( is_page() && $post->post_parent ) {
			$this->pageIsPageWithParent();
		}

		if ( is_search() ) {
			$this->pageIsSearch();
		}

		if ( is_tag() ) {
			$this->pageIsTag();
		}

		if ( is_404() ) {
			$this->pageIs404();
		}

		if ( get_query_var( 'paged' ) ) {
			$this->pageIsPaged();
		}

		echo $this->trail->render();
	}
}
