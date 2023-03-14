<?php
function delete_temp_files()
{
    $upload_dir = wp_upload_dir();
    $upload_dir = $upload_dir['basedir'];
    $upload_dir = $upload_dir . '/job_applications';
    $tempFolder = $upload_dir . '/temp';

    $files = glob($tempFolder . '/*'); // get all file names
    $current_time = time();
    $three_hours_ago = $current_time  - (3 * 60 * 60);

    foreach ($files as $file) { // iterate files
        if (is_file($file)) {
            if (filectime($file) < $three_hours_ago) {
                unlink($file);
            }
        }
    }
}
add_action('delete_temp_files', 'delete_temp_files');

if (!wp_next_scheduled('delete_temp_files')) {
    $timeToRun = '24 * 60 * 60';

    wp_schedule_event(time(), $timeToRun, 'delete_temp_files');
}

// Delete job application posts older than 90 days
function delete_job_application_posts()
{
    $args = array(
        'post_type' => 'job_applications',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        // older than 90 days
        'date_query' => array(
            array(
                'before' => '90 days ago',
                'inclusive' => true,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            wp_delete_post(get_the_ID(), true);
        }
    }
    wp_reset_postdata();
}

add_action('delete_job_application_posts', 'delete_job_application_posts');

if (!wp_next_scheduled('delete_job_application_posts')) {
    $timeToRun = '24 * 60 * 60';

    wp_schedule_event(time(), $timeToRun, 'delete_job_application_posts');
}

// Delete job application files older than 90 days
function delete_application_files()
{
    $parentDirectory = wp_upload_dir()['basedir'] . '/job_applications';
    // Get all folders and files in the parent directory. If they are older than 90 days, delete them.
    $files = glob($parentDirectory . '/*');
    $current_time = time();
    $ninety_days_ago = $current_time  - (90 * 24 * 60 * 60);
    foreach ($files as $file) {
        if (is_file($file) && filemtime($file) < $ninety_days_ago) {
            unlink($file);
        } elseif (is_dir($file)) {
            // Get all files in the subdirectory. If they are older than 90 days, delete them.
            $subfiles = glob($file . '/*');
            foreach ($subfiles as $subfile) {
                if (is_file($subfile) && filemtime($subfile) < $ninety_days_ago) {
                    unlink($subfile);
                }
            }
            // If the subdirectory is now empty, delete it.
            if (count(glob($file . '/*')) === 0) {
                rmdir($file);
            }
        }
    }
}

add_action('delete_application_files', 'delete_application_files');

if (!wp_next_scheduled('delete_application_files')) {
    $timeToRun = '24 * 60 * 60';

    wp_schedule_event(time(), $timeToRun, 'delete_application_files');
}
