<?php
if (pll_current_language('slug') == 'en') {
    $fieldTarget = "";
} else {
    $fieldTarget = '_' . pll_current_language('slug');
}
?>

<section id="cta-contact">
    <div class="row">
        <?php
        if (get_field('cta_contact_text' . $fieldTarget, 'option')) : ?>
            <p> <?php the_field('cta_contact_text' . $fieldTarget, 'option'); ?> </p>
        <?php
        endif;
        ?>
        <?php
        if (get_field('cta_contact_button_text' . $fieldTarget, 'option')) : ?>
            <a href="<?php the_field('cta_contact_button_link' . $fieldTarget, 'option'); ?>" class="btn btn-light btn-light-lg">
                <?php the_field('cta_contact_button_text' . $fieldTarget, 'option'); ?>
            </a>
        <?php
        endif;
        ?>
    </div>
</section>