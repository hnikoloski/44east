<?php
get_header();
?>
<div class="featured-image">
    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover" />
</div>
<main id="primary" class="site-main">
    <header>
        <div class="meta">
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
        </div>
        <h1><?php
            $title = strip_tags(get_the_title());
            echo $title;
            ?></h1>
        <div class="author">
            <?php
            $post_id = get_the_ID();
            $author_id = get_post_field('post_author', $post_id);
            $author_img = get_avatar_url($author_id);
            $author_name = get_the_author_meta('display_name', $author_id);
            ?>
            <div class="img-wrapper">

                <img src="<?php echo $author_img; ?>" alt="<?php the_author(); ?>" class="full-size-img full-size-img-cover">
            </div>
            <div class="info">
                <p class="name"><?php echo $author_name; ?></p>
                <?php if (get_field('job_role', 'user_' . $author_id)) : ?>
                    <p class="title"><?php the_field('job_role', 'user_' . $author_id); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <article class="main-content">
        <?php
        the_content();
        ?>
    </article>

</main>

<?php
get_footer();
