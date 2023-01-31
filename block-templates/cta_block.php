<?php

/**
 * Cta Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-cta-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$background = get_field('cta_block_bg_color') ?: '#4AA380';
$ctaText = get_field('cta_block_text');
$buttonText = get_field('cta_block_button_text');
$buttonLink = get_field('cta_block_button_link');
?>

<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>" style="--bgColor:<?php echo $background; ?>">
    <div class="row">
        <?php
        if ($ctaText) : ?>
            <p> <?php echo $ctaText; ?> </p>
        <?php
        endif;
        ?>
        <?php
        if ($buttonText) : ?>
            <a href="<?php echo $buttonLink; ?>" class="btn btn-light btn-light-lg">
                <?php echo $buttonText; ?>
            </a>
        <?php
        endif;
        ?>
    </div>
</div>