<?php

/**
 * Services Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-services-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Fields
$sectionTitle = get_field('services_block_title');
?>


<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>">
    <div class="container">

        <?php if ($sectionTitle) : ?>
            <h2 class="block-deco-title"><?php echo $sectionTitle; ?></h2>
        <?php endif; ?>
        <div class="row">
            <?php
            $args = array(
                'post_type' => 'services',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            );
            $loop = new WP_Query($args);

            if ($loop->have_posts()) :
                while ($loop->have_posts()) : $loop->the_post();
            ?>
                    <div class="single-service" data-href="<?php the_permalink(); ?>">
                        <div class="img-wrapper">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover">
                        </div>
                        <h3><?php the_title(); ?></h3>
                        <?php
                        $excerpt = get_the_excerpt();
                        if (strlen($excerpt) > 280) {
                            $excerpt = substr($excerpt, 0, 280) . '...';
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