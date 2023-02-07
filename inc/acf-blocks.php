<?php

// Path: inc\acf-blocks.php

// Block categories
add_filter('block_categories_all', function ($categories) {

    // Adding a new category.
    $categories[] = array(
        'slug'  => '44east',
        'title' => '44east',
        // icon the logo
        'icon'  => '44east',
        'order' => 1,
    );

    return $categories;
});

// Editor styles
add_action('enqueue_block_editor_assets', 'starter_editor_styles');
function starter_editor_styles()
{
    wp_enqueue_style('ff-east-editor-styles', get_template_directory_uri() . '/dist/css/editor.css');
}

function starter_acf_init_block_types()
{

    if (function_exists('acf_register_block_type')) {

        // Decorative Column block
        acf_register_block_type(
            array(
                'name'              => 'decorative-column',
                'title'             => __('Decorative Content Column'),
                'description'       => __('A block to display column with text.'),
                'render_template'   => 'block-templates/deco-content-column.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('decorative', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Hero block
        acf_register_block_type(
            array(
                'name'              => 'hero',
                'title'             => __('Hero'),
                'description'       => __('A block to display hero.'),
                'render_template'   => 'block-templates/hero-block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('hero', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Our Team block
        acf_register_block_type(
            array(
                'name'              => 'our-team',
                'title'             => __('Our Team'),
                'description'       => __('A block to display our team.'),
                'render_template'   => 'block-templates/our-team.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('our team', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Cta Block
        acf_register_block_type(
            array(
                'name'              => 'cta',
                'title'             => __('Call to Action'),
                'description'       => __('A block to display call to action.'),
                'render_template'   => 'block-templates/cta_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('cta', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Services Block
        acf_register_block_type(
            array(
                'name'              => 'services',
                'title'             => __('Services'),
                'description'       => __('A block to display services.'),
                'render_template'   => 'block-templates/services.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('services', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Cta Text Block
        acf_register_block_type(
            array(
                'name'              => 'cta-text',
                'title'             => __('Call to Action Text'),
                'description'       => __('A block to display call to action text.'),
                'render_template'   => 'block-templates/cta_text_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('cta text', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Testimonials Block
        acf_register_block_type(
            array(
                'name'              => 'testimonials',
                'title'             => __('Testimonials'),
                'description'       => __('A block to display testimonials.'),
                'render_template'   => 'block-templates/testimonials_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('testimonials', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Faq Block
        acf_register_block_type(
            array(
                'name'              => 'faq',
                'title'             => __('FAQ'),
                'description'       => __('A block to display faq.'),
                'render_template'   => 'block-templates/faq_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('faq', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Facts Block
        acf_register_block_type(
            array(
                'name'              => 'facts',
                'title'             => __('Facts'),
                'description'       => __('A block to display facts.'),
                'render_template'   => 'block-templates/facts_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('facts', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Related Services Block
        acf_register_block_type(
            array(
                'name'              => 'related-services',
                'title'             => __('Related Services'),
                'description'       => __('A block to display related services.'),
                'render_template'   => 'block-templates/related_services_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('related services', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Recent Posts Block
        acf_register_block_type(
            array(
                'name'              => 'recent-posts',
                'title'             => __('Recent Posts'),
                'description'       => __('A block to display recent posts.'),
                'render_template'   => 'block-templates/recent_posts_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('recent posts', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // All Posts Block
        acf_register_block_type(
            array(
                'name'              => 'all-posts',
                'title'             => __('All Posts'),
                'description'       => __('A block to display all posts.'),
                'render_template'   => 'block-templates/all_posts_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('all posts', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Person block
        acf_register_block_type(
            array(
                'name'              => 'person',
                'title'             => __('Person'),
                'description'       => __('A block to display person.'),
                'render_template'   => 'block-templates/person_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('person', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Jobs Board Block
        acf_register_block_type(
            array(
                'name'              => 'jobs-board',
                'title'             => __('Jobs Board'),
                'description'       => __('A block to display jobs board.'),
                'render_template'   => 'block-templates/jobs_board_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('jobs board', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        // Still Apply Block
        acf_register_block_type(
            array(
                'name'              => 'still-apply',
                'title'             => __('Still Apply'),
                'description'       => __('A block to display still apply.'),
                'render_template'   => 'block-templates/still_apply_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('still apply', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        //Share Btns Block
        acf_register_block_type(
            array(
                'name'              => 'share-btns',
                'title'             => __('Share Buttons'),
                'description'       => __('A block to display share buttons.'),
                'render_template'   => 'block-templates/share_btns_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('share buttons', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );

        //Related Posts Block
        acf_register_block_type(
            array(
                'name'              => 'related-posts',
                'title'             => __('Related Blog Posts'),
                'description'       => __('A block to display related Blog posts.'),
                'render_template'   => 'block-templates/related_blogs_block.php',
                'category'          => '44east',
                'icon'              => '44east',
                'keywords'          => array('related blog posts', '44east'),
                'supports'          => array(
                    'mode' => true,
                ),
            ),
        );
    }
}

add_action('acf/init', 'starter_acf_init_block_types');
