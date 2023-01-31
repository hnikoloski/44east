<?php

/**
 * Testimonials Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-testimonials-block testimonials-swiper';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>


<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>">
    <?php
    // Get Testimonials post type
    $args = array(
        'post_type' => 'testimonials',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    $loop = new WP_Query($args);
    if ($loop->have_posts()) :
    ?>
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                    <!-- Slides -->
                    <?php
                    $postId = get_the_ID();
                    $image = get_the_post_thumbnail_url();
                    $name = get_field('testimonial_name', $postId);
                    $person_title = get_field('testimonial_persons_title', $postId);
                    $theTestimonial = get_field('testimonial_full', $postId);
                    ?>
                    <div class="swiper-slide single-testimonial">
                        <div class="person-info">
                            <div class="img-wrapper">
                                <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
                            </div>
                            <div>
                                <h5><?php echo $name; ?></h5>
                                <p><?php echo $person_title; ?></p>
                            </div>
                        </div>
                        <p class="testimonial"><?php echo $theTestimonial; ?></p>
                    </div>
                <?php endwhile; ?>


            </div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev">
                <span class="material-symbols-outlined">
                    west
                </span>
            </div>
            <div class="swiper-button-next">
                <span class="material-symbols-outlined">
                    east
                </span>
            </div>

            <!-- If we need scrollbar -->
            <div class="swiper-scrollbar"></div>
        </div>
    <?php endif;
    wp_reset_postdata();
    ?>
</div>