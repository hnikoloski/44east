<?php if (get_field('partners', 'option')) : ?>

    <section id="our-partners">
        <?php
        $partners = get_field('partners', 'option');
        if ($partners) :
        ?>
            <div class="swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <?php foreach ($partners as $partner) : ?>
                        <div class="swiper-slide">
                            <?php if ($partner['partner_link']) { ?>
                                <a class="img-wrapper" target="_blank" rel="noopener noreferrer" class="d-block" href="<?php echo $partner['partner_link']; ?>">
                                    <img src="<?php echo $partner['partner_logo']; ?>" alt="<?php echo $partner['partner_name']; ?>" class="full-size-img full-size-img-contain">
                                </a>
                            <?php } else { ?>
                                <div class="img-wrapper">
                                    <img src="<?php echo $partner['partner_logo']; ?>" alt="<?php echo $partner['partner_name']; ?>" class="full-size-img full-size-img-contain">
                                </div>
                            <?php } ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


    </section>
<?php endif; ?>