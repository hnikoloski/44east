<?php

/**
 * Facts Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-facts-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Block Title
$styleVars = '';
$blockTitle = get_field('facts_block_title');
$textColor = get_field('facts_block_title_color') ? get_field('facts_block_title_color') : '#64B5F6';

$styleVars .= '--facts-block-title-color: ' . $textColor . '; ';

$blockBackground = get_field('facts_block_background_color') ? get_field('facts_block_background_color') : '#0D174A';
$styleVars .= '--facts-block-background-color: ' . $blockBackground . '; ';
?>


<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>" style="<?php echo $styleVars; ?>">
    <div class="container">
        <?php if (get_field('facts_block_title')) : ?>
            <h2 class="block-title"><?php echo $blockTitle; ?></h2>
        <?php endif; ?>
        <?php if (have_rows('facts_block_facts')) : ?>
            <ul class="facts">
                <?php while (have_rows('facts_block_facts')) : the_row();
                    $theFact = get_sub_field('fact_block_single_fact');
                ?>
                    <li>
                        <?php echo $theFact; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>