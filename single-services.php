<?php
get_header();
?>
<div class="featured-image">
    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover" />
</div>
<main id="primary" class="site-main">
    <?php
    the_content();
    ?>
</main>

<?php
get_footer();
