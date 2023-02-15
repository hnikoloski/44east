<?php

// Display a table of all uploaded files for the applicant in the edit page
function ff_display_applicant_files($post)
{
    // Check if the post type is job_applications
    if ('job_applications' != $post->post_type) {
        return;
    }

    // Get the first and last name of the applicant
    $first_name = get_field('first_name', $post->ID);
    $last_name = get_field('last_name', $post->ID);
    $taxonomy = get_the_terms($post->ID, 'job_position')[0]->slug;
    $taxonomyName = get_the_terms($post->ID, 'job_position')[0]->name;
    // Get the location of the applicant's folder in the uploads directory
    $upload_dir = wp_upload_dir();
    $upload_dir = $upload_dir['basedir'];
    $upload_dir = $upload_dir . '/job_applications'  . '/' . $taxonomy . '/' . $first_name . '_' . $last_name . '_' . $post->ID;

    // Check if the folder exists
    if (!file_exists($upload_dir)) {
        return;
    }

    // Get the list of files in the applicant's folder
    $files = scandir($upload_dir);

    // Remove '.' and '..' from the list of files
    $files = array_diff($files, array('.', '..'));

    // Display a table of all the uploaded files
    if (!empty($files)) {
        // Display the table header
        echo '<h2>Uploaded Files</h2>';
        echo '<table class="widefat fixed" cellspacing="0">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>File Name</th>';
        echo '<th>File URL</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($files as $file) {
            $fileUrl = $upload_dir . '/' . $file;
            // Replace the parts before /wp-content with the site URL
            $fileUrl = str_replace(ABSPATH . 'wp-content', site_url() . '/wp-content', $fileUrl);

            echo '<tr>';
            echo '<td>' . $file . '</td>';
            echo '<td><a href="' . $fileUrl . '" target="_blank">Download</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    // custom css
    echo '<style>
        #job_positiondiv{
            display: none;
        }
    </style>';
    if ($taxonomy == 'other') {
        echo '<h2 style = "margin: 25px 0;padding: 10px;background-color: #fff;text-align: center;border: 5px double #2271b1;font-size: 20px;">';
        echo $first_name . ' ' . $last_name . ' did not select a job position when applying.';
    } else {
        echo '<h2 style = "margin: 25px 0;padding: 10px;background-color: #fff;text-align: center;border: 5px double green;font-size: 20px;">';
        echo $first_name . ' ' . $last_name . ' applied for the job position: ' . $taxonomyName;
    }
    echo '</h2>';
}

// Add the custom function to the edit page for the job_applications post type
add_action('edit_form_after_title', 'ff_display_applicant_files');
