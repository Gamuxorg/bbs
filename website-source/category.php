<?php
/*
 * 分类模板
*/ 
get_header(); ?>
<div class="container-fluid">
  <nav class="row" aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb mb-1 p-1 col-sm-3 col-lg-2">
      <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">首页</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo get_the_category()[0]->name; ?></li>
    </ol>
  </nav>
</div>
<div class="d-none col-sm-3 col-lg-2 d-sm-flex container-fluid">
  <div class="row">
    <ul class="list-unstyled">
    <?php
      $categories=get_categories();
      foreach($categories as $category) {
    ?>
        <li class="listgame-li"><a href="#" categoryid="<?php echo $category->term_id; ?>"><?php echo $category->name; ?>[<?php echo  $category->count; ?>]</a></li>
    <?php } ?>
    </ul>
  </div>
</div>

<div class="col-12 col-sm-9 col-lg-10 d-flex flex-column">
  <div class="container-fluid gamux-1">
    <div class="row gamux-11">
    </div>
  </div>
  <div class="w-100 mt-4 gamux-2">
    <ul class="pagination justify-content-center" id="pagination"></ul>
  </div>
</div>
<?php get_footer(); ?>