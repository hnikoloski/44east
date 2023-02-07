<?php
get_header();
?>
<div class="featured-image">
    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover" />
</div>
<main id="primary" class="site-main">
    <?php
    $post = get_post();
    $post->post_content = '<h1>' . $post->post_title . '</h1>' . $post->post_content;
    setup_postdata($post);

    // Start the Loop.
    while (have_posts()) :
        the_post();
        the_content();
    endwhile; // End the loop.

    // Restore original Post Data
    wp_reset_postdata();
    ?>
</main>

<?php
get_footer();
