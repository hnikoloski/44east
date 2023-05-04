<?php

/**
 * All Posts Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-jobs-board-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>

<div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
    <div class="container">
        <input type="hidden" name="job_type_hidden" id="jobTypeHidden">
        <input type="hidden" name="job_category_hidden" id="jobCategoryHidden">
        <header>
            <?php
            //taxonomy=job_type&post_type=jobs
            //get all terms in taxonomy
            $terms = get_terms(array(
                'taxonomy' => 'job_type',
                'hide_empty' => false,
                // Only show current language
            ));

            if ($terms) {
            ?>
                <ul class="filter filter-for-desktop">
                    <li><a href="*" class="active filter-item">All</a></li>
                    <?php
                    foreach ($terms as $term) {
                        $term_link = get_term_link($term);
                        if (is_wp_error($term_link)) {
                            continue;
                        }
                    ?>
                        <li><a href="<?php echo esc_url($term_link); ?>" data-job-category="<?php echo $term->slug; ?>" data-job-type="*" class="filter-item"><?php echo $term->name; ?></a></li>
                    <?php
                    }
                    ?>
                </ul>

                <select class="filter filter-for-mobile select-basic-second">
                    <option value="*" selected>All</option>
                    <?php
                    foreach ($terms as $term) {
                        $term_link = get_term_link($term);
                        if (is_wp_error($term_link)) {
                            continue;
                        }
                    ?>
                        <option value="<?php echo $term->slug; ?>" class="filter-item job_category_item"><?php echo $term->name; ?></option>
                    <?php
                    }
                    ?>
                </select>

            <?php
            }
            ?>

            <?php
            // Get a random page that has the needed radio field (job_type)
            $args = array(
                'post_type' => 'jobs',
                'lang' => pll_current_language(), // Only show current language
                'meta_query' => array(
                    array(
                        'key' => 'job_type',
                        'compare' => 'EXISTS'
                    )
                )
            );
            $random_page = get_posts($args);
            shuffle($random_page);
            $random_page = array_pop($random_page);
            if ($random_page) {
                $job_type = get_field('job_type', $random_page->ID);
                // Get all choices
                $choicesJobType = get_field_object('job_type', $random_page->ID)['choices'];
                // Get the label of the choice
            } else {
                echo 'No pages found with the job_type field';
            }
            ?>
            <div class="col">
                <p class="label"><?php pll_e('Filter by', 'starter'); ?></p>
                <select name="filter-by" id="filter-by" class="select-basic">
                    <option value="*" selected class="filter-item"><?php pll_e('All', 'starter'); ?></option>
                    <?php
                    foreach ($choicesJobType as $key => $value) {
                        var_dump($value);
                        echo '<option value="' . $key . '" class="filter-item">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <?php if (get_field('jobs_board_block_title')) : ?>
                    <h3 class="title"><?php the_field('jobs_board_block_title'); ?></h3>
                <?php endif; ?>
                <?php if (get_field('jobs_board_block_description')) : ?>
                    <p class="description"><?php echo get_field('jobs_board_block_description'); ?></p>
                <?php endif; ?>
            </div>
            <div class="job-results">
                <!-- Jobs fetched from api -->
                <div class="single-job">
                    <div class="top">
                        <div class="content">
                            <p class="category">DESIGN</p>
                            <h3 class="title">TITLE</h3>
                        </div>
                        <a href="#" class="btn btn-primary btn-primary-xs">View Job</a>
                    </div>
                    <p class="short-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.</p>
                    <ul>
                        <li class="job-type">
                            Full Time </li>
                        <li class="min-years">
                            Min. 5 years </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>