<?php

/**
 * Share Btns Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-share-btns-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

$blockTitle = get_field('all_posts_block_title');
$offsetPosts = get_field('all_posts_block_offset_posts') ? get_field('all_posts_block_offset_posts') : 0;
?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <p><?php pll_e('Share', 'starter'); ?></p>
    <ul class="share-buttons">
        <li>
            <a href="<?php the_permalink(); ?>" target="_blank" class="share-btn linkedin">
                <i class="fab fa-linkedin-in"></i>
                LinkedIn
            </a>
        </li>
</div>