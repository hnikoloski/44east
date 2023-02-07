<?php
// Create admin page called Newsletter Users
function newsletter_users_admin_page()
{
    add_menu_page(
        'Newsletter Users',
        'Newsletter Users',
        'manage_options',
        'newsletter-users',
        'newsletter_users_admin_page_callback',
        'dashicons-email-alt',
        6
    );
}
add_action('admin_menu', 'newsletter_users_admin_page');

function newsletter_users_admin_page_callback()
{
    $args = array(
        'post_type' => 'newsletter_users',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    $newsletter_users = get_posts($args);
    if (empty($newsletter_users)) {
        echo '<div class="wrap">';
        echo '<h1>Newsletter Users</h1>';
        echo '<p>There are no users that have signed up to the newsletter.</p>';
        echo '</div>';
        return;
    }
    $newsletter_users_array = array();

    foreach ($newsletter_users as $newsletter_user) {
        $newsletter_users_array[] = array(
            'id' => $newsletter_user->ID,
            'title' => $newsletter_user->post_title,
            'email' => get_field('email', $newsletter_user->ID),
        );
    }

    echo '<div class="wrap">';
    echo '<h1>Newsletter Users</h1>';
    echo '<p>Here you can see all the users that have signed up to the newsletter.</p>';
    // Export Button
    echo '<form action="' . admin_url('admin-post.php') . '" method="post">';
    echo '<input type="hidden" name="action" value="export_newsletter_users">';
    echo '<input type="submit" class="button button-primary" value="Export to CSV">';
    echo '</form>';
    echo '<br>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th class="manage-column">ID</th>';
    echo '<th class="manage-column">Email</th>';
    echo '<th class="manage-column">Date Added</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($newsletter_users_array as $newsletter_user) {
        echo '<tr>';
        echo '<td>' . $newsletter_user['id'] . '</td>';
        echo '<td>' . $newsletter_user['title'] . '</td>';
        $date = get_the_date('d/m/Y', $newsletter_user['id']);
        echo '<td>' . $date . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    // Delete Button
    echo '<form action="' . admin_url('admin-post.php') . '" method="post" style="text-align:right;" id="deleteNewsLetters">';
    echo '<input type="hidden" name="action" value="delete_newsletter_users">';
    echo '<input type="submit" class="button" id="deleteNewsLettersBtn" value="Delete All Users" style="color:#fff; background:firebrick; border:none; margin-top:1em;">';

    echo '</form>';



    echo '</div>';
}

// Export Newsletter Users to CSV
function export_newsletter_users()
{
    $args = array(
        'post_type' => 'newsletter_users',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    $newsletter_users = get_posts($args);

    $newsletter_users_array = array();

    foreach ($newsletter_users as $newsletter_user) {
        $newsletter_users_array[] = array(
            'id' => $newsletter_user->ID,
            'title' => $newsletter_user->post_title,
            'email' => get_field('email', $newsletter_user->ID),
        );
    }

    $filename = 'newsletter_users.csv';
    $fp = fopen('php://output', 'w');

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename=' . $filename);

    fputcsv($fp, array('ID', 'Email', 'Date Added'));

    foreach ($newsletter_users_array as $newsletter_user) {
        $date = get_the_date('d/m/Y', $newsletter_user['id']);
        fputcsv($fp, array($newsletter_user['id'], $newsletter_user['title'], $date));
    }

    exit;
}
add_action('admin_post_export_newsletter_users', 'export_newsletter_users');

// Delete All Newsletter Users
function delete_newsletter_users()
{
    $args = array(
        'post_type' => 'newsletter_users',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    $newsletter_users = get_posts($args);

    foreach ($newsletter_users as $newsletter_user) {
        wp_delete_post($newsletter_user->ID, true);
    }

    wp_redirect(admin_url('admin.php?page=newsletter-users'));
    exit;
}

add_action('admin_post_delete_newsletter_users', 'delete_newsletter_users');


// enqueue scripts just for this page
function newsletter_users_admin_scripts($hook)
{
    if ($hook != 'toplevel_page_newsletter-users') {
        return;
    }

    // js
    wp_enqueue_script('newsletter-users-admin-js', get_template_directory_uri() . '/src/admin/newsletter-users-admin.js', array('jquery'), '1.0.0', true);
    // css
    wp_enqueue_style('newsletter-users-admin-css', get_template_directory_uri() . '/src/admin/newsletter-users-admin.css', array(), '1.0.0', 'all');
}

add_action('admin_enqueue_scripts', 'newsletter_users_admin_scripts');
