<section id="latest-blogs">
    <div class="header">
        <?php if (get_field('latest_blogs_title', get_the_ID())) : ?>
            <h2><?php the_field('latest_blogs_title', get_the_ID()); ?></h2>
        <?php endif; ?>
        <?php if (get_field('latest_blogs_description', get_the_ID())) : ?>
            <p><?php the_field('latest_blogs_description', get_the_ID()); ?></p>
        <?php endif; ?>
    </div>
    <?php
    // Relationship field
    $latest_blogs = get_field('latest_blogs', get_the_ID());
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    // if $latest_blogs is empty, then we will use the default query
    if ($latest_blogs) {
        $postsId = array();
        foreach ($latest_blogs as $post) {
            $postsId[] = $post->ID;
        }
        $args['post__in'] =  $postsId;
    }

    $query = new WP_Query($args);
    ?>

    <?php if ($query->have_posts()) : ?>
        <div class="row">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="single-blog">
                    <div class="img-wrapper">
                        <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover">
                    </div>
                    <div class="meta">
                        <p>
                            <?php
                            $date = get_the_date('F j, Y');
                            echo $date . " - ";
                            ?>
                            <?php
                            $content = get_the_content();
                            $word_count = str_word_count(strip_tags($content));
                            $reading_time = ceil($word_count / 200);
                            if ($reading_time == 0) {
                                $reading_time = 1;
                            }
                            echo $reading_time . __(' min read');
                            ?>
                        </p>
                    </div>
                    <h2><?php the_title(); ?></h2>
                    <a href="<?php the_permalink(); ?>" class="btn">
                        <?php _e('Read More'); ?>
                        <span class="material-symbols-outlined">
                            arrow_circle_right
                        </span>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>





</section>