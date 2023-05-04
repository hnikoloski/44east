<?php

// Register Endpoints
add_action('rest_api_init', function () {
    register_rest_route('ff-east/v1', '/our-team', array(
        'methods' => 'GET',
        'callback' => 'ff_get_team_members',
    ));

    //single team member
    register_rest_route('ff-east/v1', '/our-team/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'ff_get_team_member',
    ));

    // Blog Categories
    register_rest_route('ff-east/v1', '/blog-categories', array(
        'methods' => 'GET',
        'callback' => 'ff_get_blog_categories',
    ));

    // Blog Posts 
    register_rest_route('ff-east/v1', '/blog-posts', array(
        'methods' => 'GET',
        'callback' => 'ff_get_blog_posts_by_category_slug',
        'permission_callback' => '__return_true'
    ));

    //Jobs Posts
    register_rest_route('ff-east/v1', '/jobs', array(
        'methods' => 'GET',
        'callback' => 'ff_get_jobs',
        'permission_callback' => '__return_true'
    ));

    // Newsletter Sign Up
    register_rest_route('ff-east/v1', '/newsletter-sign-up', array(
        'methods' => 'POST',
        'callback' => 'ff_newsletter_sign_up',
        'permission_callback' => '__return_true'
    ));

    // Job Application
    register_rest_route('ff-east/v1', '/job-application', array(
        'methods' => 'POST',
        'callback' => 'ff_job_application',
        'permission_callback' => '__return_true'
    ));

    // Upload files to temp folder
    register_rest_route('ff-east/v1', '/upload-file-temp', array(
        'methods' => 'POST',
        'callback' => 'ff_upload_file_temp',
        'permission_callback' => '__return_true'
    ));

    // Contact Form
    register_rest_route('ff-east/v1', '/contact-form', array(
        'methods' => 'POST',
        'callback' => 'ff_contact_form',
        'permission_callback' => '__return_true'
    ));
});

function ff_get_team_members()
{

    $args = array(
        'post_type' => 'team_members',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    $team_members = get_posts($args);

    $team_members_array = array();

    foreach ($team_members as $team_member) {
        $team_members_array[] = array(
            'id' => $team_member->ID,
            'title' => $team_member->post_title,
            'img' => get_the_post_thumbnail_url($team_member->ID),
            'team_member_position_title' => get_field('team_member_position_title', $team_member->ID),
            'team_member_linkedin' => get_field('team_member_linkedin', $team_member->ID),
            'team_member_email' => get_field('team_member_email', $team_member->ID),
            'team_member_description' => get_field('team_member_description', $team_member->ID),
        );
    }

    return $team_members_array;
}

function ff_get_team_member($data)
{
    $id = $data['id'];
    $team_member = get_post($id);

    $team_member = array(
        'id' => $team_member->ID,
        'title' => $team_member->post_title,
        'img' => get_the_post_thumbnail_url($team_member->ID),
        'team_member_position_title' => get_field('team_member_position_title', $team_member->ID),
        'team_member_linkedin' => get_field('team_member_linkedin', $team_member->ID),
        'team_member_email' => get_field('team_member_email', $team_member->ID),
        'team_member_description' => get_field('team_member_description', $team_member->ID),
    );

    return $team_member;
}

function ff_get_blog_categories()
{
    $categories = get_categories();

    $categories_array = array();

    foreach ($categories as $category) {
        $categories_array[] = array(
            'id' => $category->term_id,
            'title' => $category->name,
            'slug' => $category->slug,
        );
    }

    return $categories_array;
}

function ff_get_blog_posts_by_category_slug($data)
{
    $lang = $data['lang'] ? $data['lang'] : 'en';

    $offSet = $data['offSet'];
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => $offSet,
        'lang' => $lang,
    );

    if ($data['slug'] != '*' && $data['slug'] != '') {
        $slug = $data['slug'];
        $args['category_name'] = $slug;
    }

    if ($data['tag'] != '*' && $data['tag'] != '') {
        $tags = $data['tag'];
        // Return the posts that have the tags
        $args['tag'] = $tags;
    }

    $posts = get_posts($args);

    $posts_array = array();

    foreach ($posts as $post) {
        $excerpt = get_the_excerpt($post->ID);
        if (strlen($excerpt) > 250) {
            $excerpt = substr($excerpt, 0, 250) . '...';
        }
        $content = $post->post_content;
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200);
        if ($reading_time == 0) {
            $reading_time = 1;
        }
        $reading_time  = $reading_time . pll__(' min read', '44east');

        $title = $post->post_title;
        $title = strip_tags($title);

        $posts_array[] = array(
            'id' => $post->ID,
            'title' =>  $title,
            'excerpt' =>  $excerpt,
            'catName' =>  get_the_category($post->ID)[0]->name,
            'date' =>  get_the_date('F j, Y', $post->ID),
            'readTime' =>  $reading_time,
            'imgUrl' =>  get_the_post_thumbnail_url($post->ID),
            'btnTxt' => pll__('Read More', '44east'),
            'btnLink' => get_the_permalink($post->ID),
        );
    }

    return $posts_array;
}

function ff_get_jobs($data)
{
    // Language
    $lang = $data['lang'] ? $data['lang'] : 'en';

    // Switch to the correct language
    PLL()->curlang = PLL()->model->get_language($lang);

    $args = array(
        'post_type' => 'jobs',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'lang' => $lang,
    );

    //If job_type is sent return only posts in that taxonomy
    if ($data['job_category'] != '*' && $data['job_category'] != '') {
        $job_type = $data['job_category'];
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'job_type',
                'field' => 'slug',
                'terms' => $job_type,
            )
        );
    }

    // If job_type is sent return only posts that have the same acf value
    if ($data['job_type'] != '*' && $data['job_type'] != '') {
        $job_location = $data['job_type'];
        $args['meta_query'] = array(
            array(
                'key' => 'job_type',
                'value' => $job_location,
                'compare' => 'LIKE',
            )
        );
    }


    $jobs = get_posts($args);

    $jobs_array = array();

    foreach ($jobs as $job) {
        if (get_field('job_short_description', $job->ID)) {
            $short_description = get_field('job_short_description', $job->ID);
        } else {
            $short_description = get_the_excerpt($job->ID);

            if (strlen($short_description) > 250) {
                $short_description = substr($short_description, 0, 250) . '...';
            }
        }
        $jobCategories = array();
        foreach (get_the_terms($job->ID, 'job_type') as $jobCategory) {
            $jobCategories[] = array(
                'id' => $jobCategory->term_id,
                'title' => $jobCategory->name,
                'slug' => $jobCategory->slug,
                'job_category_color' => get_field('job_category_color', $jobCategory),
            );
        }

        $jobTypeArr = array();
        $jobType = get_field('job_type', $job->ID);
        $jobTypeArr = array(
            'label' => pll__($jobType['label']),
            'value' => $jobType['value'],
        );

        $jobs_array[] = array(
            'id' => $job->ID,
            'title' => $job->post_title,
            'job_category' => $jobCategories,
            'job_type' => $jobTypeArr,
            'min_years' => pll__('Min.', '44east') . get_field('min_years', $job->ID) . ' ' . pll__('years', '44east'),
            'short_description' => $short_description,
            'link' => get_the_permalink($job->ID),
            'btnTxt' => pll__('View Job', '44east'),
        );
    }

    return $jobs_array;
}

function ff_newsletter_sign_up($data)
{
    $email = $data['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //return error message
        $err_msg = array(
            'error' => true,
            'message' => pll__('Please enter a valid email address', '44east'),
        );
        return $err_msg;
    }

    // Check if email is already in the newsletter_users post type, if not add it.
    // email is used as title.
    $args = array(
        'post_type' => 'newsletter_users',
        'posts_per_page' => -1,
        'title' => $email,
    );

    $posts = get_posts($args);

    if (count($posts) == 0) {
        $post = array(
            'post_title' => $email,
            'post_type' => 'newsletter_users',
            'post_status' => 'publish',
        );

        $post_id = wp_insert_post($post);

        if ($post_id) {
            $success_msg = array(
                'error' => false,
                'message' => pll__('Thank you for signing up to our newsletter', '44east'),
            );
            return $success_msg;
        } else {
            $err_msg = array(
                'error' => true,
                'message' => pll__('Something went wrong, please try again', '44east'),
            );
            return $err_msg;
        }
    } else {
        $err_msg = array(
            'error' => true,
            'message' => pll__('You are already signed up to our newsletter', '44east'),
        );
        return $err_msg;
    }
}

function ff_job_application($data)
{
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $email = $data['email'];
    $phone = $data['phone'];
    $address = $data['address'];
    $city = $data['city'];
    $job_id = $data['job_id'];
    $lang = $data['lang'] ? $data['lang'] : 'en';

    // Switch to the correct language
    PLL()->curlang = PLL()->model->get_language($lang);

    $err_msg = array(
        'error' => false,
        'message' => '',
        'fields' => array(),
    );

    $singleFieldErrMsg = pll__('Please fill in this field', '44east');

    if ($firstName == '') {
        $err_msg['error'] = true;
        $err_msg['fields']['firstName'] = $singleFieldErrMsg;
    }

    if ($lastName == '') {
        $err_msg['error'] = true;
        $err_msg['fields']['lastName'] = $singleFieldErrMsg;
    }

    if ($email == '') {
        $err_msg['error'] = true;
        $err_msg['fields']['email'] = $singleFieldErrMsg;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err_msg['error'] = true;
        $err_msg['fields']['email'] = pll__('Please enter a valid email address', '44east');
    }

    if ($phone == '') {
        $err_msg['error'] = true;
        $err_msg['fields']['phone'] = $singleFieldErrMsg;
    } elseif (!preg_match('/^[0-9+]+$/', $phone)) {
        $err_msg['error'] = true;
        $err_msg['fields']['phone'] = pll__('Please enter a valid phone number', '44east');
    }


    if ($err_msg['error']) {
        // One or more fields have an error. Please check and try again.
        $err_msg['message'] = pll__('One or more fields have an error. Please check and try again.', '44east');
        return $err_msg;
    }

    // Check the uploaded file
    if (!isset($_FILES['files'])  || $_FILES['files']['error'] !== UPLOAD_ERR_OK) {
        // Return error message
        $err_msg = array(
            'error' => true,
            'message' => pll__('An error occurred while uploading your resume. Or you did not upload a resume. Please try again.', '44east'),

        );
        return $err_msg;
    }



    // Check file extension
    $allowed = array('pdf', 'doc', 'docx');
    $filename = $_FILES['files']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($ext, $allowed)) {
        // Return error message
        $err_msg = array(
            'error' => true,
            'message' => pll__('Please upload a PDF, DOC or DOCX file', '44east'),
        );
    }

    // Create a job_application folder in the uploads folder if it doesn't exist. Then create a folder for the job application based on the job title.
    $upload_dir = wp_upload_dir();
    $upload_dir = $upload_dir['basedir'];
    $upload_dir = $upload_dir . '/job_applications';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if ($job_id == 'other' || $job_id == '') {
        $job_position = 'Other';
        $job_positionFullName = 'Other';
    } else {
        $job_position = get_the_title($job_id);
        $job_positionFullName = $job_position;
        // Convert the job title to a slug
        $job_position = sanitize_title($job_position);
    }

    $post = array(
        'post_title' => $firstName . ' ' . $lastName,
        'post_type' => 'job_applications',
        'post_status' => 'publish',
    );

    $post_id = wp_insert_post($post);

    // Set job_position taxonomy to the $job_id
    wp_set_object_terms($post_id, $job_positionFullName, 'job_position');


    if (!file_exists($upload_dir . '/' . $job_position)) {
        mkdir($upload_dir . '/' . $job_position, 0755, true);
    }


    // Store the uploaded file
    if (isset($_FILES['files'])) {
        $file_tmp_name = $_FILES['files']['tmp_name'];
        $file_name = $_FILES['files']['name'];
        // Create a folder for the applicant
        $applicant_folder = $firstName . '_' . $lastName . '_' . $post_id;
        if (!file_exists($upload_dir . '/' . $job_position . '/' . $applicant_folder)) {
            mkdir($upload_dir . '/' . $job_position . '/' . $applicant_folder, 0755, true);
        }
        $dateUploaded = date('Y-m-d');
        $file_location = $upload_dir . '/' . $job_position . '/' . $applicant_folder . '/' . uniqid() . '_' . $dateUploaded . '-' . $file_name;
        if (move_uploaded_file($file_tmp_name, $file_location)) {
            if ($post_id) {
                // update acf fields
                update_field('first_name', $firstName, $post_id);
                update_field('last_name', $lastName, $post_id);
                update_field('email', $email, $post_id);
                update_field('phone', $phone, $post_id);
                update_field('address', $address, $post_id);
                update_field('city', $city, $post_id);
                update_field('job_position', $job_position, $post_id);
                update_field('resume', $file_location, $post_id);
                // Return success message
                $success_msg = array(
                    'error' => false,
                    'message' => pll__('Your job application has been submitted successfully!', '44east'),
                );

                // Send auto reply email
                $to = $email;
                $custom_logo_id = get_theme_mod('custom_logo');
                $logoUrl = wp_get_attachment_image_src($custom_logo_id, 'full');
                $logoUrl = $logoUrl[0];
                $contactEmail = get_field('contact_email', 'option') ? get_field('contact_email', 'option') : get_option('admin_email');

                $headers = array('Content-Type: text/html; charset=UTF-8');
                $headers[] = 'From: 44 East <' . $contactEmail . '>';

                $message = '<table style="width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #ccc; border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 1.5; color: #333;">';
                $message .= '<tr><td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #0d174a; text-align: center;"><img src="' . $logoUrl . '" alt="44 East" style="max-width: 100%; height: auto;"></td></tr>';
                $message .= '<tr><td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><h1 style="font-size: 24px; line-height: 1.2; color: #333; margin: 0;">' . pll__('Thank you for your interest in 44 East', '44east') . '</h1></td></tr>';

                $message .= '<tr><td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('We have received your application and will be in touch soon.', '44east') . '</p></td></tr>';

                $message .= '<tr><td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('If you have any questions, please contact us at', '44east') . ' <a href="mailto:' . $contactEmail . '" style="color: #333; text-decoration: none;">' . $contactEmail . '</a></p></td></tr>';

                $message .= '<tr><td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('Thank you, 44 East', '44east') . '</p></td></tr>';
                $message .= '</table>';

                $subject = pll__('Thank you for your interest in 44 East', '44east');

                wp_mail($to, $subject, $message, $headers);




                return $success_msg;
            }
        } else {
            // Return error message
            $err_msg = array(
                'error' => true,
                'message' => pll__('An error occurred while uploading your resume. Please try again.', '44east'),
            );
            return $err_msg;
        }
    }
}

function ff_upload_file_temp()
{
    $upload_dir = wp_upload_dir();
    $upload_dir = $upload_dir['basedir'];
    $upload_dir = $upload_dir . '/job_applications/temp';

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Check if a file was uploaded
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $file['name'] = str_replace(' ', '_', $file['name']);
        // Generate a unique file name
        $file_name = uniqid() . '-' . $file['name'];
        $file_path = $upload_dir . '/' . $file_name;

        // Move the uploaded file to the temp folder
        move_uploaded_file($file['tmp_name'], $file_path);

        // Return a success message
        return array(
            'message' => 'File uploaded successfully',
            'file_path' => $file_path
        );
    }

    // Return an error message if no file was uploaded
    return array(
        'error' => 'No file was uploaded'
    );
}

function ff_contact_form($data)
{
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $email = $data['email'];
    $phone = $data['phone'];
    $message = $data['message'];

    $lang = $data['lang'] ? $data['lang'] : 'en';

    $err_msg = array(
        'error' => false,
        'message' => '',
        'fields' => array(),
    );

    // Switch to the correct language
    PLL()->curlang = PLL()->model->get_language($lang);

    $err_msg = array(
        'error' => false,
        'message' => '',
        'fields' => array(),
    );

    $singleFieldErrMsg = pll__('Please fill in this field', '44east');

    if ($firstName == '') {
        $err_msg['error'] = true;
        $err_msg['fields']['firstName'] = $singleFieldErrMsg;
    }

    if ($lastName == '') {
        $err_msg['error'] = true;
        $err_msg['fields']['lastName'] = $singleFieldErrMsg;
    }

    if ($email == '') {
        $err_msg['error'] = true;
        $err_msg['fields']['email'] = $singleFieldErrMsg;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err_msg['error'] = true;
        $err_msg['fields']['email'] = pll__('Please enter a valid email address', '44east');
    }

    if ($phone == '') {
        $err_msg['error'] = true;
        $err_msg['fields']['phone'] = $singleFieldErrMsg;
    } elseif (!preg_match('/^[0-9+]+$/', $phone)) {
        $err_msg['error'] = true;
        $err_msg['fields']['phone'] = pll__('Please enter a valid phone number', '44east');
    }


    if ($err_msg['error']) {
        // One or more fields have an error. Please check and try again.
        $err_msg['message'] = pll__('One or more fields have an error. Please check and try again.', '44east');
        return $err_msg;
    }

    $custom_logo_id = get_theme_mod('custom_logo');
    $logoUrl = wp_get_attachment_image_src($custom_logo_id, 'full');

    $contactEmail = get_field('contact_email', 'option') ? get_field('contact_email', 'option') : get_option('admin_email');

    //    Send email to admin
    $to = $contactEmail;
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: ' . $firstName . ' ' . $lastName . ' <' . $email . '>';

    $subject = pll__('44 East Contact form submission', '44east');

    $emailMessage = '<table style="border: 1px solid #ccc; border-collapse: collapse; width: 100%;">';
    $emailMessage .= '<tr>
    <td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><img src="' . $logoUrl[0] . '" alt="44 East" style="max-width: 100%; height: auto;"></td>
    <td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><h1 style="margin: 0;">' . pll__('Contact form submission', '44east') . '</h1></td>
    </tr>';

    $emailMessage .= '<tr>';
    $emailMessage .= '<td style="width:25%;padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('First name', '44east') . '</p></td>';
    $emailMessage .= '<td style="width:75%; padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . $firstName . '</p></td>';
    $emailMessage .= '</tr>';

    $emailMessage .= '<tr>';
    $emailMessage .= '<td style="width:25%; padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('Last name', '44east') . '</p></td>';
    $emailMessage .= '<td style="width:75%;padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . $lastName . '</p></td>';
    $emailMessage .= '</tr>';

    $emailMessage .= '<tr>';
    $emailMessage .= '<td style="width:25%; padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('Email', '44east') . '</p></td>';
    $emailMessage .= '<td style="width:75%;padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . $email . '</p></td>';
    $emailMessage .= '</tr>';

    $emailMessage .= '<tr>';
    $emailMessage .= '<td style="width:25%; padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('Phone', '44east') . '</p></td>';
    $emailMessage .= '<td style="width:75%;padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . $phone . '</p></td>';
    $emailMessage .= '</tr>';

    $emailMessage .= '<tr>';
    $emailMessage .= '<td style="width:25%; padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('Message', '44east') . '</p></td>';
    $emailMessage .= '<td style="width:75%;padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . $message . '</p></td>';
    $emailMessage .= '</tr>';

    $emailMessage .= '</table>';

    //Footer table
    $emailMessage .= '<table style="border: 1px solid #ccc; border-collapse: collapse; width: 100%;">';
    $emailMessage .= '<tr>';
    $emailMessage .= '<td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('This email was sent from the contact form on', '44east') .  ' ' . get_bloginfo('name') . '</p></td>';
    $emailMessage .= '</tr>';

    $emailMessage .= '<tr>';
    $emailMessage .= '<td style="padding: 10px; border: 1px solid #ccc; border-collapse: collapse; background-color: #fff; text-align: center;"><p style="margin: 0;">' . pll__('This email was sent from the IP address', '44east') . ' ' . $_SERVER['REMOTE_ADDR'] . '</p></td>';
    $emailMessage .= '</tr>';
    $emailMessage .= '</table>';

    wp_mail($to, $subject, $emailMessage, $headers);


    $success_msg = array(
        'error' => false,
        'message' => pll__('Thank you for your message. We will be in touch shortly.', '44east'),
    );

    // Create post in the contact_form_submission custom post type
    $post = array(
        'post_title' => $firstName . ' ' . $lastName,
        'post_content' => $message,
        'post_status' => 'publish',
        'post_type' => 'contact_form_submiss',
    );

    $post_id = wp_insert_post($post);

    // Update acf fields
    update_field('first_name', $firstName, $post_id);
    update_field('last_name', $lastName, $post_id);
    update_field('email', $email, $post_id);
    update_field('phone', $phone, $post_id);
    update_field('message', $message, $post_id);



    return $success_msg;
}
