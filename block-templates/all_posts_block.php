<?php

/**
 * All Posts Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-all-posts-block';
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
    <input type="hidden" name="offsetPosts" id="offsetPosts" value="<?php echo $offsetPosts; ?>">
    <header>
        <div class="col">
            <?php if ($blockTitle) : ?>
                <h3><?php echo $blockTitle; ?></h3>
            <?php endif; ?>
            <ul class="categories filter active filter-for-desktop">
                <li><a href="*" data-filter="*" class="active filter-item">All</a></li>
                <?php
                $categories = get_categories();
                // Do not show uncategorized or empty categories
                $categories = array_filter($categories, function ($category) {
                    return $category->name !==  $category->count > 0;
                });
                foreach ($categories as $category) {
                ?>
                    <li><a href="<?php echo get_category_link($category->term_id); ?>" data-filter="<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></li>
                <?php
                }
                ?>
            </ul>
            <select class="filter active categories filter-for-mobile select-basic-second">
                <option value="*" selected>All</option>
                <?php
                foreach ($categories as $category) {
                ?>
                    <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
                <?php
                }
                ?>
            </select>

            <ul class="tags filter filter-for-desktop">
                <li><a href="*" class="active">All</a></li>
                <?php
                $tags = get_tags();
                foreach ($tags as $tag) {
                ?>
                    <li><a href="<?php echo get_tag_link($tag->term_id); ?>" data-filter="<?php echo $tag->slug; ?>"><?php echo $tag->name; ?></a></li>
                <?php
                }
                ?>
            </ul>
            <select class="filter tags filter-for-mobile select-basic-second">
                <option value="*" selected>All</option>
                <?php
                foreach ($tags as $tag) {
                ?>
                    <option value="<?php echo $tag->slug; ?>"><?php echo $tag->name; ?></option>
                <?php
                }
                ?>
            </select>
            <input type="hidden" name="hidden_tags" id="hiddenTags">
            <input type="hidden" name="hidden_categories" id="hiddenCategories">
        </div>
        <div class="col">
            <p class="label"><?php pll_e('Filter by', 'starter'); ?></p>
            <select name="filter-by" id="filter-by" class="select-basic">
                <option value="category" selected><?php pll_e('Categories', 'starter'); ?></option>
                <option value="tag"><?php pll_e('Tag', 'starter'); ?></option>
            </select>
        </div>
    </header>
    <div class="results">

    </div>
</div>