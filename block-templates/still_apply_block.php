<?php

/**
 * Testimonials Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-still-apply-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>


<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>">
    <div class="row">
        <?php
        // if both subheading and title are empty, then don't show the column
        if (get_field('still_apply_subheading') || get_field('still_apply_title')) : ?>
            <div class="col">
                <?php if (get_field('still_apply_subheading')) : ?>
                    <p><?php the_field('still_apply_subheading'); ?></p>
                <?php endif; ?>
                <?php if (get_field('still_apply_title')) : ?>
                    <h3><?php the_field('still_apply_title'); ?></h3>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="col">
            <?php if (get_field('still_apply_description')) : ?>
                <?php the_field('still_apply_description'); ?>
            <?php endif; ?>
            <?php if (get_field('still_apply_button_text')) : ?>
                <a href="/apply-now" class="btn btn-primary btn-m open-modal"><?php the_field('still_apply_button_text'); ?></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="apply-modal">
        <div class="modal-content">
            <a href="#" class="close-modal">
                <span class="material-symbols-outlined">
                    close
                </span>
            </a>
            <h3><?php pll_e('Start Your Career', 'starter'); ?></h3>
            <?php
            if (is_singular('jobs')) {
                $jobId = get_the_ID();
                // Get the slug
                $jobId = get_post_field('post_name', $jobId);
            } else {
                $jobId = 'other';
            }
            ?>
            <?php
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $main_domain = $protocol . "://" . $_SERVER['HTTP_HOST'];
            ?>
            <form action="<?php echo $main_domain ?>/wp-json/ff-east/v1/job-application" data-job-id="<?php echo $jobId; ?>" id="jobAppForm" data-lang="<?php echo pll_current_language(); ?>" novalidate>
                <input type="hidden" name="job_id" value="<?php echo $jobId; ?>">
                <div class="form-control">
                    <label for="firstName"><?php pll_e('First Name', 'starter'); ?></label>
                    <input type="text" name="firstName" id="firstName" required>
                </div>
                <div class="form-control">
                    <label for="lastName"><?php pll_e('Last Name', 'starter'); ?></label>
                    <input type="text" name="lastName" id="lastName" required>
                </div>
                <div class="form-control">
                    <label for="email"><?php pll_e('Email', 'starter'); ?></label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-control">
                    <label for="phone"><?php pll_e('Phone', 'starter'); ?></label>
                    <input type="tel" name="phone" id="phone" required>
                </div>
                <div class="form-control">
                    <label for="address"><?php pll_e('Address', 'starter'); ?></label>
                    <input type="text" name="address" id="address">
                </div>
                <div class="form-control">
                    <label for="city"><?php pll_e('City', 'starter'); ?></label>
                    <input type="text" name="city" id="city">
                </div>
                <div class="form-control w-100 hidden">
                    <ul class="files-selected">
                        <!-- Js  -->
                    </ul>
                </div>
                <div class="w-100 form-control mb-5">
                    <label for="uploadFiles" class="d-block w-100"><?php pll_e('Files', 'starter'); ?><span class="req"></span></label>
                    <div class="form-control upload dropzone" data-text="<?php pll_e('Choose File', '44east'); ?>">

                        <!-- <label for="uploadFiles"><?php pll_e('Files', 'starter'); ?></label>
                    <div class="wrapper">
                        <p>
                            <?php
                            pll_e('Choose File', 'starter');
                            ?>
                        </p>
                    </div> -->
                    </div>
                </div>

                <div class="form-control">
                    <input type="submit" value="<?php pll_e('Submit Application', 'starter'); ?>" class="btn btn-primary btn-m w-100">
                </div>
                <div class="status-msg">
                    <p></p>
                </div>
            </form>
        </div>
    </div>
</div>