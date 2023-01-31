<?php

/**
 * Related Services Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-related-services-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$currentServiceId = get_the_ID();
?>

<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>">
    <div class="container">
        <header>
            <h2><?php pll_e('Other Services', 'starter'); ?></h2>
            <a href="<?php echo get_home_url() . '/services'; ?>" class="btn btn-arrow">
                <?php pll_e('View All Services', 'starter'); ?> <span class="material-symbols-outlined">
                    arrow_circle_right
                </span>
            </a>
        </header>
        <div class="row">
            <?php
            $args = array(
                'post_type' => 'services',
                'posts_per_page' => 3,
                'orderby' => 'rand',
                'post__not_in' => array($currentServiceId)
            );
            $loop = new WP_Query($args);

            if ($loop->have_posts()) :
                while ($loop->have_posts()) : $loop->the_post();
            ?>
                    <div class="single-service">
                        <div class="img-wrapper">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover">
                        </div>
                        <h3><?php the_title(); ?></h3>
                        <?php
                        $excerpt = get_the_excerpt();
                        if (strlen($excerpt) > 680) {
                            $excerpt = substr($excerpt, 0, 680) . '...';
                        }
                        echo '<p>' . $excerpt . '</p>';
                        ?>
                        <a href="<?php the_permalink(); ?>" class="btn btn-arrow">
                            <?php pll_e('Learn More', 'starter'); ?>
                            <span class="material-symbols-outlined">
                                arrow_circle_right
                            </span>
                        </a>
                    </div>
            <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>


        </div>
    </div>
</div>