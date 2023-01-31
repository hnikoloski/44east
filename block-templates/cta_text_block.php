<?php

/**
 * Cta Text Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-cta-text-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$styleVars = '';
if (get_field('cta_text_block_bg_color')) {
    $styleVars .= '--bgColor:' . get_field('cta_text_block_bg_color') . ';';
}
if (get_field('cta_text_block_bg_image')) {
    $styleVars .= '--bgImage:url(' . get_field('cta_text_block_bg_image') . ');';
}
if (get_field('cta_text_block_before_img')) {
    $styleVars .=  '--beforeImg:url(' . get_field('cta_text_block_before_img') . ');';
}
if (get_field('cta_text_block_after_img')) {
    $styleVars .=  '--afterImg:url(' . get_field('cta_text_block_after_img') . ');';
}

if (get_field('cta_text_block_before_width')) {
    $styleVars .= '--beforeWidth:' . get_field('cta_text_block_before_width') . 'px;';
}
if (get_field('cta_text_block_after_width')) {
    $styleVars .= '--afterWidth:' . get_field('cta_text_block_after_width') . 'px;';
}

if (get_field('cta_text_block_before_height')) {
    $styleVars .= '--beforeHeight:' . get_field('cta_text_block_before_height') . 'px;';
}
if (get_field('cta_text_block_after_height')) {
    $styleVars .= '--afterHeight:' . get_field('cta_text_block_after_height') . 'px;';
}


?>

<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>" style="<?php echo $styleVars; ?>">
    <div class="container">
        <?php if (get_field('cta_text_block_the_text')) : ?>
            <h3><?php the_field('cta_text_block_the_text'); ?></h3>
        <?php endif; ?>
    </div>
</div>