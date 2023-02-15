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

    </header>
    <article class="main-content">
        <?php
        the_content();
        ?>
    </article>

</main>

<?php
get_footer();
