<?php

/**
 * Our Team Block Template.
 */

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ffeast-our-team-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$sectionTitle = get_field('our_team_block_title');
?>


<div <?= $anchor; ?>class="<?= esc_attr($class_name); ?>">
    <?php if ($sectionTitle) : ?>
        <h2 class="block-title"><?php echo $sectionTitle; ?></h2>
    <?php endif; ?>

    <div class="row">
        <?php
        $args = array(
            'post_type' => 'team_members',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        $loop = new WP_Query($args);

        if ($loop->have_posts()) :
            while ($loop->have_posts()) : $loop->the_post();
        ?>
                <div class="single-team-member" data-id="<?php echo get_the_ID();  ?>">
                    <div class="img-wrapper">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" class="full-size-img full-size-img-cover">
                    </div>
                    <h2><?php the_title(); ?></h2>
                    <?php if (get_field('team_member_position_title', get_the_ID())) : ?>
                        <p><?php echo the_field('team_member_position_title', get_the_ID()); ?></p>
                    <?php endif; ?>
                    <ul class="socials">
                        <?php if (get_field('team_member_linkedin', get_the_ID())) : ?>
                            <li><a href="<?php the_field('team_member_linkedin', get_the_ID()); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a></li>
                        <?php endif; ?>
                        <?php if (get_field('team_member_email', get_the_ID())) : ?>
                            <li><a href="mailto:<?php the_field('team_member_email', get_the_ID()); ?>" target="_blank"><i class="fa fa-envelope"></i></a></li>
                        <?php endif; ?>
                    </ul>


                </div>
            <?php
            endwhile;
            ?>
            <div class="member-modal">
                <div class="modal-dialog">
                    <a href="#" class="close-modal" title="Close"><span></span><span></span></a>
                    <div class="top">
                        <div class="img-wrapper">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" class="full-size-img full-size-img-cover">

                        </div>
                        <div class="content">
                            <h2 class="person-title"><?php the_title(); ?></h2>
                            <?php if (get_field('team_member_position_title', get_the_ID())) : ?>
                                <p><?php echo the_field('team_member_position_title', get_the_ID()); ?></p>
                            <?php endif; ?>
                            <ul class="socials">
                                <li><a href="<?php the_field('team_member_linkedin', get_the_ID()); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="mailto:<?php the_field('team_member_email', get_the_ID()); ?>" target="_blank"><i class="fa fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <?php if (get_field('team_member_description', get_the_ID())) : ?>
                        <div class="description">
                            <?php echo the_field('team_member_description', get_the_ID()); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php
        endif;
        ?>
    </div>
    <div class="cta-section">
        <div class="col">
            <h2 class="has-ff-accent-01-color has-text-color"><strong><?php the_field('our_team_block_cta_title') ?></strong></h2>
        </div>
        <div class="col">
            <p><?php the_field('our_team_block_cta_description'); ?></p>
            <a href="<?php the_field('our_team_block_cta_link_to'); ?>" class="btn btn-arrow"><?php the_field('our_team_block_cta_button_text'); ?>
                <span class="material-symbols-outlined">
                    arrow_circle_right
                </span>
            </a>
        </div>
    </div>
</div>