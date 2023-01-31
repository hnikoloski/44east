<?php

/**
 * Hero Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-hero-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$background = get_field('hero_block_background');

if ($background) {
    $background = 'url(' . $background . ')';
}
?>

<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>" style="--bgImg:<?php echo $background; ?>">
    <div class="wrapper">
        <?php if (get_field('hero_block_before_title')) : ?>
            <h6><?php the_field('hero_block_before_title'); ?></h6>
        <?php endif; ?>
        <?php if (get_field('hero_block_title')) : ?>
            <h1><?php the_field('hero_block_title'); ?></h1>
        <?php endif; ?>

        <?php if (get_field('hero_block_subtitle')) : ?>
            <?php the_field('hero_block_subtitle'); ?>
        <?php endif; ?>
    </div>
</div>