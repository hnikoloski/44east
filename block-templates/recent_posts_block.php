<?php

/**
 * Recent Posts Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-recent-posts-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}


?>

<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>">
    <div class="container">
        <div class="row">
            <?php
            // Get the most recent post
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish'
            );
            $loop = new WP_Query($args);
            if ($loop->have_posts()) :
            ?>
                <?php while ($loop->have_posts()) : $loop->the_post();
                    $title = strip_tags(get_the_title());

                ?>
                    <div class="single-post single-post-featured">
                        <div class="img-wrapper">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $title; ?>" class="full-size-img full-size-img-cover">
                        </div>
                        <div class="wrapper">

                            <div class="meta">
                                <p>
                                    <?php
                                    $date = get_the_date('M j, Y');
                                    echo $date . " - ";
                                    ?>
                                    <?php
                                    $content = get_the_content();
                                    $word_count = str_word_count(strip_tags($content));
                                    $reading_time = ceil($word_count / 200);
                                    if ($reading_time == 0) {
                                        $reading_time = 1;
                                    }
                                    echo $reading_time . pll__(' min read');
                                    ?>
                                </p>
                                <ul class="categories">
                                    <?php
                                    $categories = get_the_category();
                                    foreach ($categories as $category) {
                                    ?>
                                        <li><?php echo $category->name; ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <h2 class="title">
                                <?php
                                //strip html tags from title
                                echo $title;
                                ?>
                            </h2>
                            <p class="excerpt">
                                <?php
                                $excerpt = get_the_excerpt();
                                if (strlen($excerpt) > 250) {
                                    $excerpt = substr($excerpt, 0, 250) . '...';
                                }
                                echo $excerpt;
                                ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-arrow">
                                <?php pll_e('Read More', 'starter'); ?>
                                <span class="material-symbols-outlined">
                                    arrow_circle_right
                                </span>
                            </a>
                        </div>
                    </div>

            <?php
                endwhile;
            endif; ?>
            <?php wp_reset_postdata(); ?>

            <?php
            // Get the next 2 most recent posts
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 2,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish',
                'offset' => 1
            );
            $loop = new WP_Query($args);
            if ($loop->have_posts()) :
            ?>
                <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                    <?php
                    //strip html tags from title
                    $title = strip_tags(get_the_title());
                    ?>
                    <div class="single-post">
                        <div class="img-wrapper">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $title; ?>" class="full-size-img full-size-img-cover">
                        </div>
                        <div class="wrapper">
                            <div class="meta">
                                <p>
                                    <?php
                                    $date = get_the_date('M j, Y');
                                    echo $date . " - ";
                                    ?>
                                    <?php
                                    $content = get_the_content();
                                    $word_count = str_word_count(strip_tags($content));
                                    $reading_time = ceil($word_count / 200);
                                    if ($reading_time == 0) {
                                        $reading_time = 1;
                                    }
                                    echo $reading_time . pll__(' min read');
                                    ?>
                                </p>
                                <ul class="categories">
                                    <?php
                                    $categories = get_the_category();
                                    foreach ($categories as $category) {
                                    ?>
                                        <li><?php echo $category->name; ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <h2 class="title">
                                <?php echo $title; ?>
                            </h2>
                            <p class="excerpt">
                                <?php
                                $excerpt = get_the_excerpt();
                                if (strlen($excerpt) > 80) {
                                    $excerpt = substr($excerpt, 0, 80) . '...';
                                }
                                echo $excerpt;
                                ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-arrow">
                                <?php pll_e('Read More', 'starter'); ?>
                                <span class="material-symbols-outlined">
                                    arrow_circle_right
                                </span>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>


            <?php endif; ?>
            <?php wp_reset_postdata(); ?>

        </div>
    </div>
</div>