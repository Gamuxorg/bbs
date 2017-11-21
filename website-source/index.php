<?php 
/*
 * 首页模板
*/
get_header(); ?>
<div class="col-12 col-sm-10 col-lg-9 col-xl-8 d-flex container-fluid">
  <div class="gamux-1 row">
    <?php $posts = query_posts('orderby=date&showposts=12'); ?>
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <div class="media mb-3 col-6 col-lg-4 cantianer-fluid">
      <div class="row">
        <a class="align-self-center md-mr-2 mr-2" href="<?php the_permalink(); ?>">
          <img class="gamux-1-icon" src="<?php echo get_thumbnail_url($post->ID); ?>" alt="LOGO">
        </a>
        <div class="media-body align-self-center">
          <div class="media-heading"><a class="" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
          <div class="d-flex flex-column gamux-1-info">
            <span class="gamux-1-cat"><?php echo get_the_category()[0]->name; ?></span>
            <span class="d-none d-sm-block gamux-1-author"><?php the_author(); ?></span>
            <span class="d-none d-sm-block">版本：<?php echo downlist_array()['version']; ?></span>
          </div>          
        </div>
      </div>
    </div> 
    <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</div>
<div class="col-lg-3 col-sm-2 col-xl-4 d-none d-sm-block container-fluid">
  <div class="row d-flex">
  <a class="btn btn-primary btn-block " href="<?php echo site_url().'/wp-admin/post-new.php'; ?>" role="button">投递游戏</a>
  <button type="button" class="btn btn-outline-primary btn-block" disabled>已发布：<?php echo wp_count_posts()->publish; ?></button>
  </div>
</div>
<?php get_footer(); ?>
