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
        $reading_time  = $reading_time . __(' min read');

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
            'btnTxt' => __('Read More', 'starter'),
            'btnLink' => get_the_permalink($post->ID),
        );
    }

    return $posts_array;
}


function ff_get_jobs($data)
{
    // Language
    $lang = $data['lang'] ? $data['lang'] : 'en';

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
            $short_description = '';
        }
        $jobs_array[] = array(
            'id' => $job->ID,
            'title' => $job->post_title,
            'job_category' => get_the_terms($job->ID, 'job_type')[0]->name,
            'job_category_color' => get_field('job_category_color', get_the_terms($job->ID, 'job_type')[0]),
            'job_type' => get_field('job_type', $job->ID),
            'min_years' => pll__('Min.', 'starter') . get_field('min_years', $job->ID) . ' ' . pll__('years', 'starter'),
            'short_description' => $short_description,
            'link' => get_the_permalink($job->ID),
            'btnTxt' => pll__('View Job', 'starter'),
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
            'message' => pll__('Please enter a valid email address', 'starter'),
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
                'message' => pll__('Thank you for signing up to our newsletter', 'starter'),
            );
            return $success_msg;
        } else {
            $err_msg = array(
                'error' => true,
                'message' => pll__('Something went wrong, please try again', 'starter'),
            );
            return $err_msg;
        }
    } else {
        $err_msg = array(
            'error' => true,
            'message' => pll__('You are already signed up to our newsletter', 'starter'),
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

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //return error message
        $err_msg = array(
            'error' => true,
            'message' => pll__('Please enter a valid email address', 'starter'),
        );
        return $err_msg;
    }

    // Create a job_application folder in the uploads folder if it doesn't exist. Then create a folder for the job application based on the job title.
    $upload_dir = wp_upload_dir();
    $upload_dir = $upload_dir['basedir'];
    $upload_dir = $upload_dir . '/job_applications';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if ($job_id == 'other') {
        $job_position = 'Other';
    } else {
        $job_position = get_the_title($job_id);
    }

    $post = array(
        'post_title' => $firstName . ' ' . $lastName,
        'post_type' => 'job_applications',
        'post_status' => 'publish',
    );

    $post_id = wp_insert_post($post);



    if (!file_exists($upload_dir . '/' . $job_position)) {
        mkdir($upload_dir . '/' . $job_position, 0777, true);
    }

    // Store the uploaded file
    if (isset($_FILES['files'])) {
        $file_tmp_name = $_FILES['files']['tmp_name'];
        $file_name = $_FILES['files']['name'];
        $file_location = $upload_dir . '/' . $job_position . '/' . uniqid() . '_' . $file_name;
        if (move_uploaded_file($file_tmp_name, $file_location)) {
            if ($post_id) {
                // update acf fields
                update_field('first_name', $firstName, $post_id);
                update_field('last_name', $lastName, $post_id);
                update_field('email', $email, $post_id);
                update_field('phone', $phone, $post_id);
                update_field('address', $address, $post_id);
                update_field('city', $city, $post_id);
                // Set the taxonomy job_position to the $job_position variable 
                wp_set_object_terms($post_id, $job_position, 'job_position');
                // Set files to the acf field files
                update_field('files', $file_location, $post_id);
            }
        } else {
            // error uploading the file
            // return error message
            $err_msg = array(
                'error' => true,
                'message' => pll__('Error uploading file', 'starter'),
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
        mkdir($upload_dir, 0777, true);
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
