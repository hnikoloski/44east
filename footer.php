<?php

if (pll_current_language('slug') == 'en') {
    $fieldTarget = "";
} else {
    $fieldTarget = '_' . pll_current_language('slug');
}

?>


<footer id="colophon" class="site-footer">
    <div class="site-info">
        <div class="col col-about">
            <?php if (get_field('footer_logo' . $fieldTarget, 'option')) {
                $imgSrc = get_field('footer_logo' . $fieldTarget, 'option');
            } else {
                $custom_logo_id = get_theme_mod('custom_logo');
                $logoUrl = wp_get_attachment_image_src($custom_logo_id, 'full');
                $imgSrc = $logoUrl[0];
            }; ?>
            <div class="logo-wrapper">
                <img src="<?php echo $imgSrc; ?>" alt="<?php echo get_bloginfo(); ?>" class="full-size-img full-size-img-contain">
            </div>
            <?php if (get_field('footer_description' . $fieldTarget, 'option')) : ?>
                <p><?php the_field('footer_description' . $fieldTarget, 'option'); ?></p>
            <?php endif; ?>
            <ul class="social">
                <?php if (get_field('linkedin_link', 'option')) : ?>
                    <li>
                        <a href="<?php the_field('linkedin_link', 'option'); ?>" target="_blank" rel="noopener noreferrer" title="LinkedIn">
                            <span class="screen-reader-text">LinkedIn</span>
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (get_field('twitter_link', 'option')) : ?>
                    <li>
                        <a href="<?php the_field('twitter_link', 'option'); ?>" target="_blank" rel="noopener noreferrer" title="Twitter">
                            <span class="screen-reader-text">Twitter</span>
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (get_field('facebook_link', 'option')) : ?>
                    <li>
                        <a href="<?php the_field('facebook_link', 'option'); ?>" target="_blank" rel="noopener noreferrer" title="Facebook">
                            <span class="screen-reader-text">Facebook</span>
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (get_field('instagram_link', 'option')) : ?>
                    <li>
                        <a href="<?php the_field('instagram_link', 'option'); ?>" target="_blank" rel="noopener noreferrer" title="Instagram">
                            <span class="screen-reader-text">Instagram</span>
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="col col-contact">
            <h3 class="footer-title"><?php pll_e('Contact', 'starter'); ?></h3>
            <?php if (have_rows('contact_details' . $fieldTarget, 'option')) : ?>
                <ul class="contact_details">
                    <?php while (have_rows('contact_details' . $fieldTarget, 'option')) : the_row();
                        $phone_orpll_email = get_sub_field('phone_orpll_email');
                        $link_to = get_sub_field('link_to');
                    ?>
                        <li>
                            <?php if ($phone_orpll_email == 'phone') : ?>
                                <a href="tel:<?php echo $link_to; ?>" title="<?php pll_e('Call us', '44east'); ?>">
                                    <?php echo $link_to; ?>
                                </a>
                            <?php else : ?>
                                <a href="mailto:<?php echo $link_to; ?>" title="<?php pll_e('Email us', '44east'); ?>">
                                    <?php echo $link_to; ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="col col-address">
            <h3 class="footer-title"><?php pll_e('Address', 'starter'); ?></h3>
            <?php if (get_field('footer_address' . $fieldTarget, 'option')) : ?>
                <p><?php the_field('footer_address' . $fieldTarget, 'option'); ?></p>
            <?php endif; ?>
        </div>
        <div class="col col-newsletter">
            <h3 class="footer-title"><?php pll_e('Subscribe', 'starter'); ?></h3>
            <?php if (get_field('footer_newsletter_description' . $fieldTarget, 'option')) : ?>
                <p><?php the_field('footer_newsletter_description' . $fieldTarget, 'option'); ?></p>
            <?php endif; ?>
            <?php if (get_field('newsletter_form_shortcode' . $fieldTarget, 'option')) : ?>
                <?php echo do_shortcode(get_field('newsletter_form_shortcode' . $fieldTarget, 'option')); ?>
            <?php endif; ?>
            <form action="#" class="news-letter newsletter-form">
                <div class="form-control">
                    <input type="email" name="newsletterEmail" id="newsletterEmail" placeholder="<?php pll_e('Email address', 'starter'); ?>">
                    <input type="submit" value="<?php pll_e('Subscribe', 'starter'); ?>">
                </div>
            </form>
        </div>
    </div><!-- .site-info -->
    <div class="copy-bar">
        <p>© <span class="current-year"></span> <?php pll_e('All Rights Reserved.', '44east'); ?> </p>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'legal-links',
                'menu_id'        => 'legal-links',
                'container'      => false,
            )
        );
        ?>

    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>