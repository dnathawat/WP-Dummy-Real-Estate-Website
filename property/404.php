<?php get_header(); ?>
<section class="bg-section-primary py-12"> 
  <div class="container">

  <h1 class="mt-12">Page Not Found</h1>
    <p>Sorry, but the page you were trying to view does not exist.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary mt-7 mb-7 md:mb-0" tabindex="0">Back to Home</a>
</div>
</section>
<?php get_footer(); ?>