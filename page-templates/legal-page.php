<?php

// Template Name: Legal Page Template
get_header();
?>
<div class="hero">
    <?php if (get_field('sub_title', get_the_ID())) : ?>
        <p class="sub-title"> <?php the_field('sub_title', get_the_ID()); ?></p>
    <?php endif; ?>

    <?php if (get_field('main_title', get_the_ID())) : ?>
        <h1 class="title"><?php the_field('main_title', get_the_ID()); ?></h1>
    <?php endif; ?>

    <?php if (get_field('hero_description', get_the_ID())) : ?>
        <div class="description">
            <?php the_field('hero_description', get_the_ID()); ?>
        </div>
    <?php endif; ?>
</div>
<main id="primary" class="site-main">
    <?php the_content(); ?>
</main>
<?php
get_footer();
