<?php 
/*
 *增加后台更多输入框
*/
//1 添加上传模块
function gamux_down_var() {
	$gamux_down = array(      
		"durl"   => "downurl",
		"title"  => "dtitle",
		"date"   => "ddate"
	);
	return $gamux_down;
}
function gamux_down_count() {
	global $wpdb,$post;
	$sql = "SELECT COUNT(*) FROM ".$wpdb->prefix."postmeta WHERE post_id = ".$post->ID." AND meta_key REGEXP 'downurl.'";
	return $wpdb->get_var($sql);
}
function gamux_add_upload_box() {
    add_meta_box(
      'gamux_upload_file',
      '添加下载(已有'.gamux_down_count().')',
      'gamux_inner_upload_box',
      'post',
      'advanced',
      'core'
    );
}
add_action( 'add_meta_boxes', 'gamux_add_upload_box' );
function gamux_inner_upload_box() {
	global $post;	
?>
    <form method="post" enctype="multipart/form-data" name="classic_form" id="gamux_upload_form">
        <div class="gamux-edit-upload-div">              
			<label class="gamux-edit-upload-label">
			<?php for($i = 0; $i < gamux_down_count(); $i++) { ?>
				<div class="gamux-edit-upload-option">
					<input type="text" placeholder="此处显示下载url，可粘贴外部url" name="<?php echo gamux_down_var()['durl'].'_'.$i; ?>" value="<?php echo  get_post_meta($post->ID, gamux_down_var()['durl'].'_'.$i)[0]; ?>" class="gamux-up-input" />
					<input type="text" placeholder="版本说明"  name="<?php echo gamux_down_var()['title'].'_'.$i; ?>" value="<?php echo  get_post_meta($post->ID, gamux_down_var()['title'].'_'.$i)[0]; ?>" class="gamux-text-input" />					
					<button type="button" class="gamux-up-button">上传</button>
					<button type="button" class="gamux-upload-delete">-</button>
				</div>
			<?php } ?>
			</label>
			<div class="gamux-upload-add-div"><input class="gamux-upload-add" type="button" value="增加" /></div>
		</div>
		
	</form>
<?php  }  
	wp_enqueue_style('add_extra_box', get_template_directory_uri(). '/css/add_extra_box.css');
	wp_enqueue_script('add_extra_box', get_template_directory_uri(). '/js/add_extra_box.js', array('jquery','media-upload','thickbox'));

function gamux_save_upload_box() {
	global $post;
	$post_id = $post->ID;      
	if('page' == $_POST['post_type']){   
		if(current_user_can( 'edit_page', $post_id ))   
			return $post_id;
	}
	$j = 0;
	foreach($_POST as $key=>$value) {
		if(strstr($key, gamux_down_var()['durl']) != false || strstr($key, gamux_down_var()['durl']) == '') {
			$j++;
		}
	}
	for($i = 0; $i < $j; $i++) {
		$data = array($_POST[gamux_down_var()['durl'].'_'.$i], $_POST[gamux_down_var()['title'].'_'.$i], date('y-m-d'));
		if(get_post_meta($post_id, gamux_down_var()['durl'].'_'.$i) == "" && get_post_meta($post_id, gamux_down_var()['title'].'_'.$i) == "") {   
			add_post_meta($post_id, gamux_down_var()['durl'].'_'.$i, $data[0], true);
			add_post_meta($post_id, gamux_down_var()['title'].'_'.$i, $data[1], true);
			add_post_meta($post_id, gamux_down_var()['date'].'_'.$i, $data[2], true);
		}
		else if($data[0] != get_post_meta($post_id, gamux_down_var()['durl'].'_'.$i)[0] || $data[1] != get_post_meta($post_id, gamux_down_var()['title'].'_'.$i)[0]) {
			if($data[0] == "" && $data[1] == "") {
				delete_post_meta($post_id, gamux_down_var()['durl'].'_'.$i);
				delete_post_meta($post_id, gamux_down_var()['title'].'_'.$i);
				delete_post_meta($post_id, gamux_down_var()['date'].'_'.$i);				
			}
			else {
				update_post_meta($post_id, gamux_down_var()['durl'].'_'.$i, $data[0]);
				update_post_meta($post_id, gamux_down_var()['title'].'_'.$i, $data[1]);
				update_post_meta($post_id, gamux_down_var()['date'].'_'.$i, $data[2]);
			}
		}
	}
     
}
add_action( 'save_post', 'gamux_save_upload_box' );

//2获取远程文件大小，需打开allow_url_fopen
function remote_file_size($url) {
	if($url == '' || $url == null){
		return 'null';
	}
	else {
		$header_array = get_headers($url, true);
		$size = $header_array['Content-Length'];
		if($size == 0 || $size == null) {
			return 'null';
		}
		else if($size < 1024) {
			return $size.'B';
		}
		else if($size < 1048576) {
			return round($size/1024, 2).'K';
		}
		else if($size < 1073741824) {
			return round($size/1048576, 2).'M';
		}
		else{
			return round($size/1073741824, 2).'G';
		}
	}
}
function output_downlist() {
	global $post;
	$output = '';
	for($i = gamux_down_count()-1; $i >= 0; $i--) {
		$output .=  "<tr class='d-body-tr'><th scope='col' class='d-version'>".get_post_meta($post->ID, gamux_down_var()['title'].'_'.$i)[0]."</th><td></td><td class='d-date'>".get_post_meta($post->ID, gamux_down_var()['date'].'_'.$i)[0]."</td><td class='d-size'>".remote_file_size(get_post_meta($post->ID, gamux_down_var()['durl'].'_'.$i)[0])."</td><td class='d-url'><a  href=".get_post_meta($post->ID, gamux_down_var()['durl'].'_'.$i)[0].">下载</a></td></tr>";
	}
	return $output;
}
//3显示当前文章的最新一个下载信息
function downlist_array() {
	global $post;
	$i = gamux_down_count()-1;
	$output = array(
		'version' => get_post_meta($post->ID, gamux_down_var()['title'].'_'.$i)[0],
		'downurl' => get_post_meta($post->ID, gamux_down_var()['durl'].'_'.$i)[0],
		'date'    => get_post_meta($post->ID, gamux_down_var()['date'].'_'.$i)[0]  
	);
	return $output;		
}

//4 激活缩略图
add_theme_support( 'post-thumbnails', array( 'post' ) );
set_post_thumbnail_size( 85, 85 );

//5 额外的输入栏
function add_extra_meta_box() {    
  add_meta_box(
      'extra_meta_box',
      '额外信息',
      'put_extra_meta_box',
      'post',
      'advanced',
      'default'
  );
}
add_action( 'add_meta_boxes', 'add_extra_meta_box' );
function put_extra_meta_box($post) {
    wp_nonce_field( 'rating_nonce_action', 'rating_nonce_name' );
    $buy_key = 'buy_url';
    $peizhi_key = 'peizhi';
    $bg_key = 'bg';
    $buy_value = get_post_meta( $post->ID, $buy_key );
    $peizhi_value = get_post_meta( $post->ID, $peizhi_key );
    $bg_value = get_post_meta( $post->ID, $bg_key );
    $html = '购买/源码地址，输入http(s)开头的url即可<input style="width: 100%;" name="buy_url" value="'.$buy_value[0].'">背景图片，输入http(s)开头的url即可<input style="width: 100%;" name="bg" value="'.$bg_value[0].'">运行配置<textarea name="peizhi" style="width: 100%;" rows = "10">'.$peizhi_value[0].'</textarea>';
    echo $html;
}
function save_extra_post_data( $post_id ) {
    if (!isset($_POST['rating_nonce_name'])) {
        return $post_id;
    }
    $nonce = $_POST['rating_nonce_name'];
    if (!wp_verify_nonce( $nonce, 'rating_nonce_action')) {
        return $post_id;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
    if ($_POST['post_type'] == 'post') {
        if (!current_user_can('edit_post', $post_id )) {
            return $post_id;
        }
    }

    $buy_key = 'buy_url';
    $buy_value = $_POST['buy_url'];
    $peizhi_key = 'peizhi';
    $peizhi_value = $_POST['peizhi'];
    $bg_key = 'bg';
    $bg_value = $_POST['bg'];
    update_post_meta( $post_id, $buy_key, $buy_value );
    update_post_meta( $post_id, $peizhi_key, $peizhi_value );
    update_post_meta( $post_id, $bg_key, $bg_value );
}
add_action( 'save_post', 'save_extra_post_data' );