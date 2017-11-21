<?php 
/*
 * 文章页模板
*/
//
get_header(); ?>
<div class="container-fluid">
  <nav class="" aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb mb-1 p-1 col-12 col-lg-4">
      <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">首页</a></li>
      <li class="breadcrumb-item"><a href="<?php echo get_category_link(get_the_category()[0]->term_id); ?>"><?php echo get_the_category()[0]->name; ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo get_the_title(); ?></li>
    </ol>
  </nav>
</div>
<div class="col-12 col-md-8 col-lg-7 d-flex container">
  <div class="row w-100 ml-1">
    <div class="w-100">
      <div class="media">
        <span class="align-self-center md-mr-2 mr-2"><?php the_post_thumbnail(); ?></span>
        <div class="media-body align-self-center d-flex flex-column">
          <div class="main-title-text"><h5 class="text-primary"><strong><?php the_title(); ?></strong></h5></div>
          <div class="main-title-cat"><?php the_category(' > ', multiple); ?></div>
        </div>
      </div>    
    </div>
    <div id="carouselExampleControls" class="carousel slide w-100 mt-2" data-ride="carousel">
      <div class="carousel-inner">
        <?php echo get_all_img($post->post_content);?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <div class="w-100 mt-3 game-content">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div class="w-100 game-content-head">
        <a class="btn btn-primary game-content-btn" href="#1" role="button">游戏介绍</a>
        <a class="btn btn-primary game-download-btn" href="#2" role="button">游戏下载</a>
      </div>
      <div class="w-100 game-content-main pt-2 pb-2">
        <div class="game-content-div"><?php the_content(); ?></div>
        <div class="game-download-div">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">版本说明</th>
                <th scope="col">下载量</th>
                <th scope="col">日期</th>
                <th scope="col">容量</th>
                <th scope="col">下载</th>
              </tr>
            </thead>
            <tbody>
              <?php echo output_downlist(); ?>
              <tr>
                <th scope="row">共<?php echo gamux_down_count(); ?>个文件</th>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
              </tr>              
            </tbody>
          </table>			
        </div>
      </div>
      <?php endwhile; endif; ?>
      <div class="w-100 game-comments mt-2">
        <div class="game-comments-div"><?php comments_template(); ?></div>
      </div>
    </div>    
  </div>
</div>

<div class="col-lg-5 col-md-4 d-none d-sm-block container">
  <div class="row mr-1">
    <div class="w-100">
      <a class="btn btn-primary btn-block " href="<?php echo site_url().'/wp-admin/post-new.php'; ?>" role="button">投递游戏</a>
      <?php edit_post_link('编辑本文', '', '', '', 'btn btn-primary btn-block'); ?>
      <ul class="list-unstyled mt-1">
        <li>购买/源码：<a href="<?php echo get_post_meta($post->ID, 'buy_url')[0]; ?>" target="_blank">购买/clone</a></li>
        <li>创建作者：<strong><?php echo get_the_author(); ?></strong></li>
        <li>添加时间：<?php echo get_the_time('Y-m-j'); ?></li>
        <li>修改者：<?php echo get_the_modified_author(); ?></li>
        <li>更新时间：<?php echo get_the_modified_time('Y-m-j'); ?></li>
        <li class="game-tags">游戏标签：<?php echo get_the_tag_list(); ?></li>
        <li class="d-none d-lg-block game-peizhi-title">运行配置</li>
        <div class="d-none d-lg-block game-peizhi-div"><?php echo get_post_meta($post->ID, 'peizhi')[0]; ?></div>
      </ul>
    </div>
  </div>
</div>
<?php get_footer(); ?>
