<?php

/**
 * Person Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-person-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <div class="container">
        <?php
        $personSelect = get_field('select_person_block');
        foreach ($personSelect as $post) :
            setup_postdata($post);
        ?>
            <div class="img-wrapper">
                <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>" alt="<?php echo $post->post_title; ?>" class="full-size-img full-size-img-cover">
            </div>
            <p class="name"><?php echo $post->post_title; ?></p>
            <p class="title"><?php echo get_field('team_member_position_title', $post->ID); ?></p>
            <div class="description"><?php echo get_field('team_member_description', $post->ID); ?></div>
            <ul class="socials">
                <?php if (get_field('team_member_linkedin', $post->ID)) : ?>
                    <li><a href="<?php the_field('team_member_linkedin', $post->ID); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a></li>
                <?php endif; ?>
                <?php if (get_field('team_member_email', $post->ID)) : ?>
                    <li><a href="mailto:<?php the_field('team_member_email', $post->ID); ?>" target="_blank"><i class="fa fa-envelope"></i></a></li>
                <?php endif; ?>
            </ul>
        <?php
        endforeach; ?>
        <?php
        // Reset the global post object so that the rest of the page works correctly.
        wp_reset_postdata(); ?>
    </div>
</div>