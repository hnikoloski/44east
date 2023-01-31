<section id="featured-blogs">
    <?php
    $featured_posts = get_field('featured_blogs');

    if ($featured_posts) :
        $counter = 1;
    ?>
        <div class="blogs-wrapper">
            <?php foreach ($featured_posts as $post) :
                if ($counter === 1) {
                    $bgColor = get_field('card_color') ? get_field('card_color') : '#070E2F';
                } elseif ($counter === 2) {
                    $bgColor = get_field('card_color') ? get_field('card_color') : '#25316D';
                } else {
                    $bgColor = get_field('card_color') ? get_field('card_color') : '#2D4E9C';
                }
                // Setup this post for WP functions (variable must be named $post).
                setup_postdata($post); ?>
                <div class="blog-card blog-card-featured" style="--bgColor<?php echo $counter; ?>:<?php echo $bgColor; ?>">
                    <div class="img-wrapper">
                        <img src="<?= get_field('featured_icon'); ?>" alt="<?= get_the_title(); ?>" class="full-size-img full-size-img-contain">
                    </div>
                    <h3><?php the_title(); ?></h3>

                    <?php
                    $excerpt = get_the_excerpt();

                    if (strlen($excerpt) > 102) {
                        $excerpt = substr($excerpt, 0, 102) . '...';
                    }
                    ?>
                    <p><?php echo $excerpt; ?></p>

                    <a href="<?php the_permalink(); ?>">
                        <?php pll_e('View More', 'starter'); ?>
                        <span class="material-symbols-outlined">
                            arrow_circle_right
                        </span>
                    </a>
                </div>
            <?php
                $counter++;
            endforeach; ?>
        </div>
        <?php
        // Reset the global post object so that the rest of the page works correctly.
        wp_reset_postdata(); ?>
    <?php endif; ?>
    <p class="action"><?php pll_e('Get Interest About Our Service Function?', 'starter'); ?> <a href="#!"><?php pll_e('Learn More', 'starter'); ?></a></p>
</section>