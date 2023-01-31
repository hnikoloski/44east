<section id="intro">
    <div class="col">
        <?php if (get_field('intro_subtitle', get_the_ID())) : ?>
            <p class="intro__subtitle"><?php the_field('intro_subtitle', get_the_ID()); ?></p>
        <?php endif; ?>
        <?php if (get_field('intro_title', get_the_ID())) : ?>
            <h2 class="intro__title"><?php the_field('intro_title', get_the_ID()); ?></h2>
        <?php endif; ?>
    </div>
    <div class="col">
        <?php if (get_field('intro_description', get_the_ID())) : ?>
            <p class="intro__description"><?php the_field('intro_description', get_the_ID()); ?></p>
        <?php endif; ?>
        <?php if (get_field('intro_button_link', get_the_ID())) : ?>
            <a href="<?php the_field('intro_button_link', get_the_ID()); ?>" class="btn btn-arrow"><?php the_field('intro_button_text', get_the_ID()); ?> <span class="material-symbols-outlined">
                    arrow_circle_right
                </span></a>
        <?php endif; ?>
    </div>
</section>