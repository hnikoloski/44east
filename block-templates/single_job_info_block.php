<?php

/**
 * Single job info Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-single-job-info-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}
$jobType = get_field('job_type', get_the_ID());

// Check if it is on a single job page
if (is_singular('jobs')) {
?>

    <div <?= $anchor; ?> class="<?= esc_attr($class_name); ?>">
        <div class="card">
            <h6><?php pll_e('About this position', 'starter'); ?></h6>
            <ul>
                <?php if (get_field('company_name', get_the_ID())) : ?>
                    <li>
                        <span><?php pll_e('Company name:', 'starter'); ?></span>
                        <?php the_field('company_name', get_the_ID()); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('start_date', get_the_ID())) : ?>
                    <li>
                        <span><?php pll_e('Start date:', 'starter'); ?></span>
                        <?php the_field('start_date', get_the_ID()); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('job_application_deadline', get_the_ID())) : ?>
                    <li>
                        <span><?php pll_e('Application deadline:', 'starter'); ?></span>
                        <?php the_field('job_application_deadline', get_the_ID()); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('job_workplace', get_the_ID())) : ?>
                    <li>
                        <span><?php pll_e('Workplace:', 'starter'); ?></span>
                        <?php the_field('job_workplace', get_the_ID()); ?>
                    </li>
                <?php endif; ?>
                <li>
                    <span><?php pll_e('Title:', 'starter'); ?></span>
                    <?php the_title(); ?>
                </li>

                <?php if (get_field('job_type', get_the_ID())) : ?>
                    <li>
                        <span><?php pll_e('Position:', 'starter'); ?></span>
                        <?php echo esc_html($jobType['label']); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('job_extent', get_the_ID())) : ?>
                    <li>
                        <span><?php pll_e('Extent:', 'starter'); ?></span>
                        <?php the_field('job_extent', get_the_ID()); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('job_number_of_positions', get_the_ID())) : ?>
                    <li>
                        <span><?php pll_e('Number of positions:', 'starter'); ?></span>
                        <?php the_field('job_number_of_positions', get_the_ID()); ?>
                    </li>
                <?php endif; ?>
        </div>
    </div>

<?php
    // If not on a single job page
} else {
    echo '<h1>' . pll__('This block can only be used on a single job page', 'starter') . '</h1>';
} ?>