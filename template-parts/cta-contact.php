<section id="cta-contact">
    <div class="row">
        <?php
        if (get_field('cta_contact_text', 'option')) : ?>
            <p> <?php the_field('cta_contact_text', 'option'); ?> </p>
        <?php
        endif;
        ?>
        <?php
        if (get_field('cta_contact_button_text', 'option')) : ?>
            <a href="<?php the_field('cta_contact_button_link', 'option'); ?>" class="btn btn-light btn-light-lg">
                <?php the_field('cta_contact_button_text', 'option'); ?>
            </a>
        <?php
        endif;
        ?>
    </div>
</section>