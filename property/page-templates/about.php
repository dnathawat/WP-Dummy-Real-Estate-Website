<?php
/* Template Name:About Us */
get_header(); ?>
<div class="section_mid">

    <?php /******Main Banner*****/ ?>
    <div class="inner-banner">



        <img src="<?php echo get_field('pg_banner_image'); ?>">
        <div class="inner-caption">
            <div class="container">
                <h2><?php the_title(); ?></h2>
            </div>
        </div>
    </div>




    <?php /******Mid_section*****/ ?>
    <?php
    $mid_section_sub_heading = get_field('mid_section_sub_heading');
    $mid_section_heading = get_field('mid_section_heading');
    $mid_section_content = get_field('mid_section_content');
    $mid_section_image = get_field('mid_section_image');
    ?>
    <div class="middle_section1 pb-0">

        <div class="container">
            <div class="middle_section1_inner">
                <div class="row">
                    <div class="middle_sec1 col-md-6">
                        <?php if ($mid_section_sub_heading) { ?>
                            <p class="sub-heading"><?php echo $mid_section_sub_heading; ?></p>
                        <?php } ?>
                        <?php if ($mid_section_heading) { ?>
                            <h2><?php echo $mid_section_heading; ?></h2>
                        <?php } ?>
                        <?php echo $mid_section_content; ?>

                    </div>
                    <div class="middle_sec2 col-md-6">
                        <?php if ($mid_section_image) { ?>
                            <img src="<?php echo $mid_section_image; ?>">
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div><?php
    $bs_sub_heading = get_field('bs_sub_heading');
    $bs_heading = get_field('bs_heading');
    $bs_content = get_field('bs_content');
    $bs_image = get_field('bs_image');
    ?>
    <div class="middle_section1">

        <div class="container">
            <div class="middle_section1_inner">
                <div class="row">
                    <div class="middle_sec1 col-md-6 order-2">
                        <?php if ($bs_sub_heading) { ?>
                            <p class="sub-heading"><?php echo $bs_sub_heading; ?></p>
                        <?php } ?>
                        <?php if ($bs_heading) { ?>
                            <h2><?php echo $bs_heading; ?></h2>
                        <?php } ?>
                        <?php echo $bs_content; ?>

                    </div>
                    <div class="middle_sec2 col-md-6">
                        <?php if ($bs_image) { ?>
                            <img src="<?php echo $bs_image; ?>">
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<?php get_footer(); ?>