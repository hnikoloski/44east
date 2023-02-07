<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * 
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="not-found-wrapper" style="--bgImg:url(<?php echo get_template_directory_uri(); ?>/assets/images/not-found-bg.webp)">
		<div class="content">
			<h6><?php pll_e('404 error', 'starter'); ?></h6>
			<h1>
				<?php pll_e('Page not found', 'starter'); ?>
			</h1>
			<p>
				<?php pll_e('Sorry, the page you are looking for doesn\'t exist.', 'starter'); ?>
			</p>
			<a href="<?php echo home_url(); ?>" class="btn btn-primary btn-m">
				<?php pll_e('Take me home', 'starter'); ?>
			</a>
		</div>

	</div>
</main><!-- #main -->

<?php
get_footer();
