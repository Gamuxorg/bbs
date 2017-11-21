<?php
/*
 * 第一部分，全局设置
**/

/*
 * 1.1 优化设置
**/
//1.1.1 去除wordpress功能
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
define( 'WP_POST_REVISIONS', 2);//只保存最近两次的版本修订
define( 'AUTOSAVE_INTERVAL', 300);//没5分钟自动保存一次

//1.1.2关闭rss
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
function wordpress_disable_feed() {
	wp_die('本站不提供rss订阅功能。');
}
add_action('do_feed', 'wordpress_disable_feed', 1);
add_action('do_feed_rdf', 'wordpress_disable_feed', 1);
add_action('do_feed_rss', 'wordpress_disable_feed', 1);
add_action('do_feed_rss2', 'wordpress_disable_feed', 1);
add_action('do_feed_atom', 'wordpress_disable_feed', 1);

//1.1.3关闭wordpress自带搜索
function fb_filter_query( $query, $error = true ) {
	if ( is_search() ) {
		$query->is_search = false;
		$query->query_vars[s] = false;
		$query->query[s] = false;
	if ( $error == true )
		$query->is_404 = true;
	}
}
add_action( 'parse_query', 'fb_filter_query' );
add_filter( 'get_search_form', create_function( '$a', 'return null;' ) );

//1.1.4关闭链接猜测功能
add_filter('redirect_canonical', 'stop_guessing');
function stop_guessing($url) {
	if (is_404()) {
		return false;
	}
	return $url;
}

//1.1.5去掉emoji加载
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//1.1.6移除admin-bar
function southbase_remove_admin_bar(){
   return false;
}
add_filter( 'show_admin_bar' , 'southbase_remove_admin_bar');

//1.1.7移除仪表盘某些组件
remove_action('welcome_panel', 'wp_welcome_panel');//欢迎面板
function remove_screen_options() {//显示选项选项卡 
	return false;
}
add_filter('screen_options_show_screen', 'remove_screen_options');
function wpse50723_remove_help($old_help, $screen_id, $screen){//帮助选项卡
	$screen->remove_help_tabs();
	return $old_help;
}
add_filter( 'contextual_help', 'wpse50723_remove_help', 999, 3 );
function gamux_remove_dashboard_widgets() {   
    global $wp_meta_boxes;    
    //删除 "快速发布" 模块  
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);                         
    // 以下这一行代码将删除 "WordPress 开发日志" 模块  
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);     
    // 以下这一行代码将删除 "其它 WordPress 新闻" 模块  
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);       
}  
add_action('wp_dashboard_setup', 'gamux_remove_dashboard_widgets' );  
/*
 * 1.2 修改wordpress功能
**/
//1.2.1修改自带jq调用规则
if ( !is_admin() ) { // 后台不禁止
function my_init_method() {
wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定义
}
add_action('init', 'my_init_method');
}
wp_deregister_script( 'l10n' );
//1.2.2 获取当前页面url
function curPageURL()
{
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
/*
 * 1.3 增加wordpress功能
**/
//1.3.1 增加github登陆
get_template_part( 'function/github_login' ); 

//1.3.2 增加编辑文章扩展功能
get_template_part( 'function/edit_extra_box' );

//1.3.3 上传文件重命名 
/*function rename_upload_file($file) {
    $time=date("Y-m-d H:i:s");
    $file['name'] = $time."".mt_rand(100,999).".".pathinfo($file['name'] , PATHINFO_EXTENSION);
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'rename_upload_file');*/

//1.3.4 修改上传目录
function slider_upload_dir($uploads) {
    $siteurl = get_option( 'siteurl' );
    $uploads['path'] = WP_CONTENT_DIR . '/uploads';
    $uploads['url'] = $siteurl . '/wp-content/uploads';
    $uploads['subdir'] = '';
    $uploads['basedir'] = $uploads['path'];
    $uploads['baseurl'] = $uploads['url'];
    $uploads['error'] = false;
    return $uploads;
}
add_filter('upload_dir', 'slider_upload_dir');

//1.3.5 增加和注销可上传类型
add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
	$existing_mimes['xz'] = 'application/x-xz';
	return $existing_mimes;
}

//1.3.6 获取特色图片的地址
function get_thumbnail_url($id) {
  $thumbid = get_post_thumbnail_id($id);
  $func = wp_get_attachment_image_src(get_post_thumbnail_id($id));
  if($func)
    return $func[0];
  else
    return "https://avatars3.githubusercontent.com/u/4121607";
}

//1.3.7 自定义url
//自定义页面模板
function loadCustomTemplate($template) {
	global $wp_query;
	if(!file_exists($template))return;
	$wp_query->is_page = true;
	$wp_query->is_single = false;
	$wp_query->is_home = false;
	$wp_query->comments = false;
	// if we have a 404 status
	if ($wp_query->is_404) {
		// set status of 404 to false
		unset($wp_query->query["error"]);
		$wp_query->query_vars["error"]="";
		$wp_query->is_404=false;
	}
	// change the header to 200 OK
	header("HTTP/1.1 200 OK");
	//load our template
	include($template);
	exit;
}
function templateRedirect() {
	$basename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	loadCustomTemplate(TEMPLATEPATH.'/gamux/'."/$basename.php");
}
add_action('template_redirect', 'templateRedirect');
//1.3.7 统计已发布文章数

/*
 * 1.4 Rest API 修改
*/
//1.4.1 增加posts API里的缩略图字段

add_action( 'rest_api_init', 'slug_register_starship' );
function slug_register_starship() {
    register_rest_field( 'post', 'gmeta', array(
		'get_callback'    => 'rest_post_gmeta',
		'update_callback' => null,
		'schema'          => null
        )
    );
}
function list_the_tags() {
	global $post;
	//输出tag列表
	$a = wp_get_post_tags($post->ID);
	$b = count($a);
	$c = [];
	if ($b == 0) {
		return '未设置标签';
	}
	else {
		for( $d=0; $d<$b; $d++ ) {
			$c[$d] = $a[$d]->name;
		}
		return $c;
	}
}
function rest_post_gmeta() {
	global $post;
	$a[0] = get_thumbnail_url($post->ID);
	$a[1] = downlist_array();
	$a[2] = get_the_category()[0]->cat_name;
  $a[3] = get_the_category()[0]->count;
	$a[4] = list_the_tags();
  $a[5] = get_the_author();
  return $a;
}

/*
 * 第二部分，前台
 */
//1.1 获取文章内图片
function get_all_img($content){
  $pattern = '/<img[^>]*src=\"([^\"]+)\"[^>]*\/?>/si';
  $matches = array();
  $out = '';
  if (preg_match_all($pattern, $content, $matches)) {
    if (count($matches[1]) == 1) {
      return '<div class="carousel-item active"><img class="d-block w-100" src="' . $matches[1][0] . '" alt="1"></div>'; 
    }
    else {
      $out1 = '<div class="carousel-item active"><img class="d-block w-100" src="' . $matches[1][0] . '" alt="1"></div>';
      for ($i = 1; $i < count($matches[1]); $i++) {        
        $out .= '<div class="carousel-item"><img class="d-block w-100" src="' . $matches[1][$i] . '" alt="'.($i+1).'"></div>';
      }
      return $out1.$out;
    }
  } 
  else {
     return "";
  }
}
add_action( 'after_setup_theme', 'default_attachment_display_settings' );
function default_attachment_display_settings() {
	update_option( 'image_default_align', 'center' );
	update_option( 'image_default_link_type', 'none' );
	update_option( 'image_default_size', 'full' );
}
