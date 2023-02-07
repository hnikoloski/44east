<?php

// Template Name: Contact
get_header();

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-hero-block alignfull';

// Load values and assign defaults.
$background = get_field('hero_block_background');

if ($background) {
    $background = 'url(' . $background . ')';
}
?>
<main id="primary" class="site-main">
    <div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>" style="--bgImg:<?php echo $background; ?>">
        <div class="wrapper">
            <?php if (get_field('hero_block_before_title')) : ?>
                <h6><?php the_field('hero_block_before_title'); ?></h6>
            <?php endif; ?>
            <?php if (get_field('hero_block_title')) : ?>
                <h1><?php the_field('hero_block_title'); ?></h1>
            <?php endif; ?>

            <?php if (get_field('hero_block_subtitle')) : ?>
                <?php the_field('hero_block_subtitle'); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="content-container">
        <div class="row">
            <div class="col col-info">
                <?php if (get_field('contact_title')) : ?>
                    <h3><?php the_field('contact_title'); ?></h3>
                <?php endif; ?>
                <ul class="contact-details">
                    <?php if (get_field('contact_address')) : ?>
                        <li class="address">
                            <?php the_field('contact_address'); ?>
                        </li>
                    <?php endif; ?>
                    <?php if (get_field('contact_email')) : ?>
                        <li class="mail">
                            <a href="mailto:<?php the_field('contact_email'); ?>"><?php the_field('contact_email'); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php
                $contact_persons = get_field('contact_persons');
                if ($contact_persons) :
                ?>
                    <ul class="contact-persons">
                        <?php foreach ($contact_persons as $post) :
                            setup_postdata($post);
                        ?>
                            <li>
                                <div class="img-wrapper">
                                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="full-size-img full-size-img-cover">
                                </div>
                                <div class="content">
                                    <p class="title"><?php the_title(); ?></p>
                                    <p class="position"><?php the_field('team_member_position_title'); ?></p>
                                    <?php if (get_field('team_member_email')) : ?>
                                        <a href="mailto:<?php the_field('team_member_email'); ?>" class="mail"><?php the_field('team_member_email'); ?></a>
                                    <?php endif; ?>
                                    <?php if (get_field('team_member_phone')) : ?>
                                        <a href="tel:<?php the_field('team_member_phone'); ?>" class="phone"><?php the_field('team_member_phone'); ?></a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php
                        endforeach;
                        wp_reset_postdata();
                        ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="col col-form">
                <?php if (get_field('contact_form_shortcode')) : ?>
                    <?php echo do_shortcode(get_field('contact_form_shortcode')); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    $map_lat = get_field('map_lat');
    $map_lng = get_field('map_lng');
    ?>
</main>
<?php if ($map_lat && $map_lng) : ?>
    <div id="map" data-lat="<?php echo $map_lat; ?>" data-lng="<?php echo $map_lng; ?>" data-marker="<?php the_field('map_marker'); ?>"></div>
<?php endif; ?>

<?php get_footer(); ?>