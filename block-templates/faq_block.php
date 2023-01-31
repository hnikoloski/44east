<?php

/**
 * Faq Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-faq-block ';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

?>


<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="content">
                    <h2><?php pll_e('Got more questions?', 'starter'); ?></h2>
                    <p><?php pll_e('Our detailed FAQ may contain the answer you are seeking.', 'starter'); ?></p>
                </div>
            </div>
            <div class="col">
                <?php
                $faqSelect = get_field('faq_block_select');

                if ($faqSelect) {
                ?>

                    <div class="accordion">
                        <?php foreach ($faqSelect as $post) :
                            setup_postdata($post);
                        ?>
                            <div class="accordion-item">
                                <div class="accordion-item-header">
                                    <h3><?php the_field('faq_question', $post->ID); ?></h3>
                                    <span class="material-symbols-outlined icon">
                                        expand_more
                                    </span>
                                </div>
                                <div class="accordion-item-body">
                                    <?php the_field('faq_answer',  $post->ID); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php wp_reset_postdata(); ?>


                    </div>
                <?php } //end IF 

                else {
                    if (get_field('number_of_latest_faqs_to_show')) {
                        $faqToShow = get_field('number_of_latest_faqs_to_show');
                    } else {
                        $faqToShow = 3;
                    }
                ?>
                    <?php
                    $args = array(
                        'post_type' => 'faq',
                        'posts_per_page' => $faqToShow,
                        'orderby' => 'rand',
                    );
                    $loop = new WP_Query($args);
                    if ($loop->have_posts()) :
                    ?>
                        <div class="accordion">
                            <?php
                            while ($loop->have_posts()) : $loop->the_post();
                            ?>
                                <div class="accordion-item">
                                    <div class="accordion-item-header">
                                        <h3><?php the_field('faq_question', get_the_ID()); ?></h3>
                                        <span class="material-symbols-outlined icon">
                                            expand_more
                                        </span>
                                    </div>
                                    <div class="accordion-item-body">
                                        <?php the_field('faq_answer', get_the_ID()); ?>
                                    </div>
                                </div>
                        <?php
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                        </div>
                    <?php
                } // end else
                    ?>
            </div>
        </div>
    </div>
</div>