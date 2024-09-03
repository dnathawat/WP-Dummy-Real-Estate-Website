<?php get_header(); ?>


<div id="content" class="main">
  <div class="container">

    <h1>
      <?php if (is_day()) : /* if the daily archive is loaded */ ?>
        <?php printf(__('Daily Archives: <span>%s</span>'), get_the_date()); ?>
      <?php elseif (is_month()) : /* if the montly archive is loaded */ ?>
        <?php printf(__('Monthly Archives: <span>%s</span>'), get_the_date('F Y')); ?>
      <?php elseif (is_year()) : /* if the yearly archive is loaded */ ?>
        <?php printf(__('Yearly Archives: <span>%s</span>'), get_the_date('Y')); ?>
      <?php elseif (is_category()) : /* If category archive is loaded */ ?>
        <?php printf(__('Category: %s'), '<span>' . single_cat_title('', false) . '</span>'); ?>
      <?php else : /* if anything else is loaded, ex. if the tags or categories template is missing this page will load */ ?>
        Blog Archives
      <?php endif; ?>
    </h1>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
    <?php endwhile;
    endif; ?>

  </div>


</div>
<?php
?>
<?php get_footer(); ?>