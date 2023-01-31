<?php
get_header();
?>
<div class="hero">
    <div class="col">
        <h1><?php the_title(); ?></h1>
        <ul>
            <?php
            $jobType = get_field('job_type');
            ?>
            <li class="job-type">
                <?php echo esc_html($jobType['label']); ?>
            </li>
            <li class="min-years">
                <?php pll_e('Min.'); ?> <?php the_field('min_years'); ?> <?php pll_e('years'); ?>
            </li>
        </ul>
    </div>
    <a href="<?php the_field('job_apply_link'); ?>" class="btn btn-primary btn-primary-lg"><?php pll_e('Apply For This Job', 'starter'); ?></a>
</div>
<main id="primary" class="site-main">
    <div class="description">
        <div class="col">
            <?php if (get_field('job_long_description')) : ?>
                <h3 class="section-title"><?php pll_e('Description:', 'starter'); ?></h3>
                <div class="content">
                    <?php the_field('job_long_description'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h6><?php pll_e('About this position', 'starter'); ?></h6>

            <ul>
                <?php if (get_field('company_name')) : ?>
                    <li>
                        <span><?php pll_e('Company name:', 'starter'); ?></span>
                        <?php the_field('company_name'); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('start_date')) : ?>
                    <li>
                        <span><?php pll_e('Start date:', 'starter'); ?></span>
                        <?php the_field('start_date'); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('job_application_deadline')) : ?>
                    <li>
                        <span><?php pll_e('Application deadline:', 'starter'); ?></span>
                        <?php the_field('job_application_deadline'); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('job_workplace')) : ?>
                    <li>
                        <span><?php pll_e('Workplace:', 'starter'); ?></span>
                        <?php the_field('job_workplace'); ?>
                    </li>
                <?php endif; ?>
                <li>
                    <span><?php pll_e('Title:', 'starter'); ?></span>
                    <?php the_title(); ?>
                </li>

                <?php if (get_field('job_type')) : ?>
                    <li>
                        <span><?php pll_e('Position:', 'starter'); ?></span>
                        <?php echo esc_html($jobType['label']); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('job_extent')) : ?>
                    <li>
                        <span><?php pll_e('Extent:', 'starter'); ?></span>
                        <?php the_field('job_extent'); ?>
                    </li>
                <?php endif; ?>
                <?php if (get_field('job_number_of_positions')) : ?>
                    <li>
                        <span><?php pll_e('Number of positions:', 'starter'); ?></span>
                        <?php the_field('job_number_of_positions'); ?>
                    </li>
                <?php endif; ?>
        </div>
    </div>

    <div class="responsibilities">
        <?php if (get_field('job_responsibilities')) : ?>
            <h3 class="section-title"><?php pll_e('Responsibilities:', 'starter'); ?></h3>
            <div class="content">
                <?php the_field('job_responsibilities'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="requirements">
        <?php if (get_field('job_requirements')) : ?>
            <h3 class="section-title"><?php pll_e('Requirements:', 'starter'); ?></h3>
            <div class="content">
                <?php the_field('job_requirements'); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
