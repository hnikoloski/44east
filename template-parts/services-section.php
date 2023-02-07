<section id="our-services">
    <div class="top-bar">
        <?php if (get_field('services_title', get_the_ID())) : ?>
            <h2 class="top-bar__title"><?php the_field('services_title', get_the_ID()); ?></h2>
        <?php endif; ?>
        <?php if (get_field('services_button_link', get_the_ID())) : ?>
            <a href="<?php the_field('services_button_link', get_the_ID()); ?>" class="btn btn-primary btn-primary-lg"><?php the_field('services_button_text', get_the_ID()); ?> </a>
        <?php endif; ?>
    </div>
    <div class="services-wrapper">
        <?php
        $featured_services = get_field('featured_services', get_the_ID());
        $counter = 1;
        ?>
        <?php foreach ($featured_services as $post) :
            if ($counter === 1) {
                $bgColor = get_field('card_color') ? get_field('card_color') : '#0D174A';
            } elseif ($counter === 2) {
                $bgColor = get_field('card_color') ? get_field('card_color') : '#2D4E9C';
            } elseif ($counter === 3) {
                $bgColor = get_field('card_color') ? get_field('card_color') : '#64B5F6';
            } else {
                $bgColor = get_field('card_color') ? get_field('card_color') : '#233178';
            }
            // Setup this post for WP functions (variable must be named $post).
            setup_postdata($post); ?>
            <div class="single-service" style="--bgColor:<?php echo $bgColor; ?>">
                <div class="top" style="--bgImage:url(<?php the_post_thumbnail_url(); ?>)">
                    <h2><?php the_title(); ?></h2>
                </div>
                <div class="bottom" style="--bgColor<?php echo $counter; ?>:<?php echo $bgColor; ?>">
                    <?php
                    $excerpt = get_the_excerpt();
                    if (strlen($excerpt) > 102) {
                        $excerpt = substr($excerpt, 0, 102) . '...';
                    }
                    ?>
                    <p><?php echo $excerpt; ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn-arrow btn-arrow-white">
                        <?php pll_e('View More', 'starter'); ?>
                        <span class="material-symbols-outlined">
                            arrow_circle_right
                        </span>
                    </a>
                </div>
            </div>
        <?php
            $counter++;
        endforeach;

        wp_reset_postdata(); ?>
    </div>
</section>