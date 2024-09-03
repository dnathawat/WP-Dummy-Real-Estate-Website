<?php get_header(); ?>
<?php
$post_type = get_post_type(get_the_ID());
$post_label = get_post_type_object($post_type)->labels->menu_name;
$parent_link = get_post_type_object($post_type)->rewrite['slug'];

$img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

if (have_posts()) {

  while (have_posts()) {
    the_post();

?>
    <div class="single-post">
      <section class="post-content">
        <div class="container">
          <p><a href="/<?= $parent_link; ?>" class="link-back"><i class="arrow_left"></i>Back to all <?= $post_label; ?></a></p>
          <img class="post-img" src="<?= $img[0]; ?>">

          <h1 class="product_type-banner-content-text banner-content-text"><?= get_the_title(); ?></h1>
          <div class="post-date"><?= get_the_date(); ?></div>
          <?php the_content(); ?>
        </div>
      </section>
    </div>
    <!-- #content-->
<?php
  }
}
?>
<?php get_footer(); ?>