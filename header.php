<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * 
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class('overflow-hidden'); ?>>
    <?php wp_body_open();
    require('template-parts/preloader.php');
    $custom_logo_id = get_theme_mod('custom_logo');
    $logoUrl = wp_get_attachment_image_src($custom_logo_id, 'full');

    ?>
    <div id="page" class="site" data-current-lang="<?php echo pll_current_language('slug'); ?>">
        <header id="masthead" class="site-header">
            <a href="<?= home_url(); ?>" class="logo-wrapper d-block">
                <img src="<?= $logoUrl[0]; ?>" alt="<?= get_bloginfo(); ?>" class="full-size-img full-size-img-contain d-block">
            </a>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                    )
                );
                ?>
            </nav><!-- #site-navigation -->

            <div class="lang-switcher">
                <?php
                //curent language
                $currentLang = pll_current_language('slug');
                ?>
                <p>
                    <?php echo $currentLang; ?> <span class="material-symbols-outlined">
                        expand_more
                    </span>
                </p>
                <ul class="lang-switcher-dropdown">
                    <?php
                    // Show language switcher with lang code
                    if (function_exists('pll_the_languages')) {
                        // Do not show current language
                        $args = array(
                            'show_flags' => 0,
                            'show_names' => 1,
                            'hide_current' => 1,
                            'display_names_as' => 'slug',
                        );
                        pll_the_languages($args);
                    }
                    ?>
            </div>
            <div id="menu-trigger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            </ul>
        </header><!-- #masthead -->

        <div id="cookie-notice" class="active">
            <p class="info">
                <?php if (pll_current_language('slug') == 'en') { ?>
                    <?php
                    $cookieNotice = get_field('cookie_notice', 'option');
                    ?>
                <?php } else {
                    $fieldTarget = 'cookie_notice_' . pll_current_language('slug');
                    $cookieNotice = get_field($fieldTarget, 'option');
                }
                ?>

                <?php
                echo $cookieNotice;
                ?>
            </p>
            <a href="#" class="btn btn-primary btn-m btn-cookie-accept">
                <?php pll_e('Accept All Cookies', 'starter'); ?>
            </a>
        </div>