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

    $offSet = $data['offSet'];
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => $offSet,
    );

    if ($data['slug'] != '*' && $data['slug'] != '') {
        $slug = $data['slug'];
        $args['category_name'] = $slug;
    }

    if ($data['tags'] != '*' && $data['tags'] != '') {
        $tags = $data['tags'];
        $args['tag'] = $tags;
        //Return posts with tags only
        $args['tag__in'] = $tags;
        $args['tag__not_in'] = array(0);
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
            'min_years' => get_field('min_years', $job->ID),
            'short_description' => $short_description,
            'link' => get_the_permalink($job->ID),
            'btnTxt' => pll__('View Job', 'starter'),
        );
    }

    return $jobs_array;
}
