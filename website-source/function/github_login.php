<?php
if(!isset($_SESSION))
  session_start();
define('GITHUB_APPID','');//请填入github的appid
define('GITHUB_APPSECRET','');//请填入github的appsecret
function github_ouath_redirect(){
	wp_safe_redirect(site_url());
	exit;
}
function github_oauth(){
    $code = $_GET['code'];
    $url = "https://github.com/login/oauth/access_token";
    $data = array('client_id' => GITHUB_APPID,
        'client_secret' => GITHUB_APPSECRET,
        'redirect_uri' => site_url(),
        'code' => $code,
        'state' => $_GET['state']);
    $response = wp_remote_post($url, array(
            'method' => 'POST',
            'headers' => array('Accept' => 'application/json'),
            'body' => $data,
			'redirection' => 5
        )
    );
	if(is_wp_error(json_decode($response['body'],true))) {
		wp_die(wp_error());
	}
	else {
	    $output = json_decode($response['body'],true);	
	}
    $token = $output["access_token"];
    if(!token) wp_die('授权失败');
    $get_user_info = "https://api.github.com/user?access_token=".$token;
    $datas = wp_remote_get( $get_user_info );
    $str = json_decode($datas['body'], true);
    $github_id = $str['id'];
    $email = $str['email'];
    $name = $str['name'];
	$github_login = $str['login'];
    if(is_user_logged_in()){
		github_ouath_redirect();
    }else{
		$user_github = get_users(array("meta_key "=>"github_id","meta_value"=>$github_id));
		if(is_wp_error($user_github) || !count($user_github)) {
			$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
			$login_name = 'github_'.$github_login;
			$userdata = array(
				'user_login' => $login_name,
				'display_name' => $name,
				'user_email' => $email,
				'user_pass' => $random_password,
				'nickname' => $name
			);
			$user_id = wp_insert_user( $userdata );
			wp_signon(array("user_login"=>$login_name,"user_password"=>$random_password),false);
			update_user_meta($user_id ,"github_id",$github_id);
			github_ouath_redirect();
		}
		else {
			update_user_meta($user_github[0]->ID ,"nickname", $name);			
            wp_set_auth_cookie($user_github[0]->ID);				
            github_ouath_redirect();
		}
    }
}
function social_oauth_github(){
    if (isset($_GET['code'])){
		github_oauth();
    }
}
add_action('init','social_oauth_github');
function github_oauth_url(){
    $url = 'https://github.com/login/oauth/authorize?client_id=' . GITHUB_APPID . '&scope=user&state=ggggaaaa&redirect_uri='.site_url();
    return $url;
}

function gamux_avatar() {
	global $current_user;
	get_currentuserinfo();
	$id = $current_user->ID;
	$github_id = get_user_meta($id, 'github_id', true);
	$avatar = 'https://avatars.githubusercontent.com/u/'. $github_id .'?v=3';
	$name = $current_user->nickname;
	return array($name, $avatar);
}
