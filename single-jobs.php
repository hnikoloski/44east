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
                <?php pll_e(esc_html($jobType['label']), '44east'); ?>
            </li>
            <li class="min-years">
                <?php pll_e('Min.'); ?> <?php the_field('min_years'); ?> <?php pll_e('years'); ?>
            </li>
        </ul>
    </div>
    <a href="<?php the_field('job_apply_link'); ?>" class="btn btn-primary btn-primary-lg"><?php pll_e('Apply for this job', '44east'); ?></a>
</div>
<main id="primary" class="site-main">

    <div class="description">
        <div class="col">
            <div class="content">
                <?php
                the_content();
                ?>
            </div>

        </div>


    </div>
</main>
<section class="application-section">
    <div class="col">
        <h3 class="section-title"><?php pll_e('Apply for this job', '44east'); ?></h3>
    </div>
    <?php
    $jobId = get_the_ID();
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $main_domain = $protocol . "://" . $_SERVER['HTTP_HOST'];
    ?>
    <form action="<?php echo $main_domain; ?>/wp-json/ff-east/v1/job-application" data-job-id="<?php echo $jobId; ?>" id="jobAppForm" class="flex" data-lang="<?php echo pll_current_language(); ?>" novalidate>
        <input type="hidden" name="job_id" value="<?php echo $jobId; ?>">
        <div class="form-control half">
            <label for="firstName"><?php pll_e('First Name', 'starter'); ?></label>
            <input type="text" name="firstName" id="firstName" required>
        </div>
        <div class="form-control half">
            <label for="lastName"><?php pll_e('Last Name', 'starter'); ?></label>
            <input type="text" name="lastName" id="lastName" required>
        </div>
        <div class="form-control half">
            <label for="email"><?php pll_e('Email', 'starter'); ?></label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-control half">
            <label for="phone"><?php pll_e('Phone', 'starter'); ?></label>
            <input type="tel" name="phone" id="phone" required>
        </div>
        <div class="form-control half">
            <label for="address"><?php pll_e('Address', 'starter'); ?></label>
            <input type="text" name="address" id="address">
        </div>
        <div class="form-control half">
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
            <input type="submit" value="<?php pll_e('Submit Application', '44east'); ?>" class="btn btn-primary btn-m w-100">
        </div>
        <div class="status-msg">
            <p></p>
        </div>
    </form>
</section>

<?php
get_footer();
