<?php if (is_front_page()) :
    $background_image = get_field('hero_background_image', get_the_ID());
?>
    <div class="hero hero-home" style="--bgImage:url(<?= $background_image; ?>);">
        <div class="hero-home__content">
            <?php if (get_field('hero_subtitle', get_the_ID())) : ?>
                <p class="hero-home__subtitle"><?= get_field('hero_subtitle', get_the_ID()); ?></p>
            <?php endif; ?>
            <?php if (get_field('hero_title', get_the_ID())) : ?>
                <h2 class="hero-home__title"><?= get_field('hero_title', get_the_ID()); ?></h2>
            <?php endif; ?>
            <?php if (get_field('hero_button_link', get_the_ID())) : ?>
                <a href="<?= get_field('hero_button_link', get_the_ID()); ?>" class="btn btn-primary btn-primary-lg"><?= get_field('hero_button_text', get_the_ID()); ?></a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>