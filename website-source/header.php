<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title> <?php echo get_bloginfo('name'); ?> | 
		<?php 
      if (is_home() || is_front_page())
        echo '为Linux用户的娱乐性而奋斗！';
      elseif (is_single())
        echo get_the_title().' for Linux';
      else
        echo '你好，gamux！';
		?>
	</title>
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/logo.ico">
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
  <?php if(is_single()) { ?>
    <link href="https://cdn.bootcss.com/wangEditor/2.1.23/wangEditor.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/single.css">
    <style>
    #main {
      background-image: url(<?php echo get_post_meta($post->ID, 'bg')[0]; ?>);
    }
    @font-face { font-family: icomoon; src: url(https://cdn.bootcss.com/wangEditor/2.1.23/fonts/icomoon.ttf); }
    </style>
  <?php }elseif(is_home()){ ?>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/index.css">
  <?php }elseif(is_category() or (strpos($_SERVER['REQUEST_URI'], 'gamelist') != false)){ ?>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/category.css">
  <?php }else{} ?>
	<?php wp_head(); ?>
</head>
<body class="w-100" id="body">
<div class="w-100" id="site">
	<header class="w-100" id="header">
    <nav class="navbar navbar-expand-md navbar-primary">
      <a class="navbar-brand text-uppercase" href="<?php echo site_url(); ?>"><?php echo get_bloginfo('name'); ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span>&#9660</span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url(); ?>">首页</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('/gamux/gamelist'); ?>">游戏列表</a>
          </li>
          <?php if(is_user_logged_in()) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">离线下载</a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="https://lixian.linuxgame.me/">离线下载</a>
                <a class="dropdown-item" href="https://www.linuxgame.me/list/">离线取回</a>
                <a class="dropdown-item" href="https://manager.linuxgame.me/">删除文件</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">使用说明</a>
              </div>
            </li>            
          <?php } ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">其他功能</a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="https://github.com/Gamuxorg/bbs/issues">寻求游戏</a>
                <a class="dropdown-item" href="#">捐赠本站</a>
                <a class="dropdown-item" href="https://github.com/Gamuxorg">开源项目</a>
                <a class="dropdown-item" href="https://tieba.baidu.com/f?ie=utf-8&kw=linux%E6%B8%B8%E6%88%8F&fr=search">Linux游戏吧</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="https://github.com/Gamuxorg/bbs/issues">论坛</a>
              </div>
            </li>
        </ul>
        <form class="d-none d-lg-block form-inline mt-2 mt-md-0">
          <label class="sr-only" for="inlineFormInputGroup">Username</label>
          <div class="input-group mb-2 mb-sm-0">
            <input class="form-control my-2 my-sm-0" type="text" placeholder="搜索暂不可用">
            <button class="btn btn-outline-primary input-group-addon my-2 my-sm-0" type="submit">寻</button>
          </div>
        </form>
        <?php if(is_user_logged_in()) { ?>
					<a class="nav-link top-login pt-0 pb-0 px-md-2 px-sm-0"><img class="rounded-circle border border-dark" src="<?php echo gamux_avatar()[1]; ?>"></a>
					<div class="site-login-info">
						<div class="site-avatar-name"><a href="<?php echo site_url().'/wp-admin'; ?>"><?php echo gamux_avatar()[0]; ?></a></div>
						<div class="site-avatar-logout"><a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout">Logout</a></div>
					</div>        
        <?php } else { ?>
        <a class="nav-link top-login pt-0 pb-0 px-md-2 px-sm-0" href="<?php echo github_oauth_url(); ?>"><img class="rounded-circle" src="https://cdn.staticfile.org/ionicons/2.0.1/png/512/social-github-outline.png"></a>
        <?php } ?>
      </div>
    </nav>	
	</header>
	<div class="w-100" id="main">
    <div class="container pt-3 pb-4" id="main-inner">
      <div class="row" id="main-inner-row">
