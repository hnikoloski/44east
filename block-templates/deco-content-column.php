<?php

/**
 * Decorative Column Content Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-deco-column-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.

?>

<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>">
    <div class="row">
        <div class="col">
            <?php if (get_field('deco_column_big_text')) : ?>
                <h2><?php the_field('deco_column_big_text'); ?></h2>
            <?php endif; ?>
        </div>
        <div class="col">
            <?php if (get_field('deco_column_small_text')) : ?>
                <?php the_field('deco_column_small_text'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>