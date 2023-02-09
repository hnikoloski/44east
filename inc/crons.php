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
    // run every 2.9 hours
    $timeToRun = '2.9 * 60 * 60';

    wp_schedule_event(time(), $timeToRun, 'delete_temp_files');
}
