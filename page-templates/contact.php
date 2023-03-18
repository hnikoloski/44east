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
                <?php
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                $main_domain = $protocol . "://" . $_SERVER['HTTP_HOST'];
                ?>
                <form action="<?php echo $main_domain; ?>/wp-json/ff-east/v1/contact-form" data-lang="<?php echo pll_current_language(); ?>">

                    <div class="form-control">
                        <label for="firstName"><?php pll_e('First Name', '44east'); ?></label>
                        <input type="text" name="firstName" id="firstName" required>
                    </div>
                    <div class="form-control">
                        <label for="lastName"><?php pll_e('Last Name', '44east'); ?></label>
                        <input type="text" name="lastName" id="lastName" required>
                    </div>
                    <div class="form-control">
                        <label for="email"><?php pll_e('Email', '44east'); ?></label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-control">
                        <label for="phone"><?php pll_e('Phone', '44east'); ?></label>
                        <input type="tel" name="phone" id="phone" required>
                    </div>
                    <div class="form-control w-100">
                        <label for="message"><?php pll_e('Message', '44east'); ?></label>
                        <textarea name="message" id="message" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-control w-fit-content top-space">
                        <input type="submit" value="<?php pll_e('Send Message', '44east'); ?>" class="btn btn-primary btn-m">
                    </div>
                    <div class="status-msg">
                        <p></p>
                    </div>
                </form>
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