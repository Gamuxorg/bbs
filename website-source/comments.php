<?php
/*
 * 评论模块
*/   
if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))   
	die ('Please do not load this page directly. Thanks!'); 
function commentid_to_userid($commentid) {
	global $wpdb;
	$sql = 'select user_id from '.$wpdb->prefix.'comments where comment_ID='.$commentid;
	$uid = $wpdb->get_var($sql);
	$sql2 = 'select meta_value from '.$wpdb->prefix.'usermeta where user_id='.$uid.' and meta_key="github_id"';
	$githubid = $wpdb->get_var($sql2);
	return $githubid;
}
function aurelius_comment($comment, $args, $depth) {   
   $comment= $GLOBALS['comment'] ?>   
  <li class="comment-list w-100 list-unstyled d-flex" id="li-comment-<?php comment_ID(); ?>">      
    <div class="comment-list-content media w-100" id="comment-<?php comment_ID(); ?>">
			<div class="comment-avatar mr-2"> 
				<img src="https://avatars.githubusercontent.com/u/<?php echo commentid_to_userid(get_comment_ID()); ?>?v=3"/>     
			</div>		
      <div class="comment-meta media-body">
				<div class="comment-meta-title">
					<div class="comment-meta-author">
						<?php echo get_comment_author_link(); ?>
						<span class="float-right"><?php comment_reply_link(array_merge( $args, array('reply_text' => '回复','depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
					</div>					
					<div class="comment-meta-data">
						<?php echo get_comment_time('Y-m-d H:i'); ?>
					</div>
				</div>
				<div class="comment-meta-content mt-1"><?php comment_text(); ?></div>
      </div>
    </div>   
  </li>   
<?php }

if ( !have_comments() ) { ?>   
   <li class="decmt-box">   
       <p><a href="#addcomment">还没有任何评论，你来说两句吧</a></p>   
   </li>   
<?php    
} else {   
        wp_list_comments('type=comment&callback=aurelius_comment');   
}   
?>
    
	<?php if ( get_option('comment_registration') && !$user_ID ) { ?>   
		<div class="unlogin-tip uk-width-1-1">你需要先<a href="<?php echo github_oauth_url(); ?>">登录</a>才能发表评论</div>   
	<?php } else {    
  
	$defaults = array( 
		'comment_field' => '<p class="comment-form-comment"><label class="labelcomment" for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment"></textarea></p>',   
		'label_submit'  => '提交评论' 
	);   
	comment_form($defaults); ?>    
<?php } ?>   
