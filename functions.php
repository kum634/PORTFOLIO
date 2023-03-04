<?php
/******************************************************************************************************************************************
*PHPのメモリー上限の書き換え
******************************************************************************************************************************************/
ini_set('memory_limit', '256M');

/******************************************************************************************************************************************
*自動更新を有効化
******************************************************************************************************************************************/
add_filter('auto_update_plugin', '__return_true'); 
add_filter('auto_update_theme', '__return_true'); 
add_filter('allow_major_auto_core_updates', '__return_true'); 
add_filter('allow_minor_auto_core_updates', '__return_true');

/******************************************************************************************************************************************
*WordPressのバージョン情報の削除
******************************************************************************************************************************************/
remove_action('wp_head', 'wp_generator'); 

/******************************************************************************************************************************************
*不要な読込みをさせない
******************************************************************************************************************************************/
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link'); 
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

/******************************************************************************************************************************************
*WordPressで自動生成される不要なページにアクセスさせない
******************************************************************************************************************************************/
function my_template_redirect($query) {
	if ( is_attachment() ) {
    $query->set_404();
		status_header( 404 );
		nocache_headers();
	} else if ( is_author() ) {
    $query->set_404();
		status_header( 404 );
		nocache_headers();
	} else if ( is_search() ) {
    $query->set_404();
		status_header( 404 );
		nocache_headers();
	} else if ( is_date() ) {
    $query->set_404();
		status_header( 404 );
		nocache_headers();
	}
}
add_action('template_redirect', 'my_template_redirect');

/******************************************************************************************************************************************
*OGPタグ生成
******************************************************************************************************************************************/
function add_my_ogp() {
  $meta .= '<!-- OGP -->' . "\n";
  $meta .= '<meta property="og:title" content="'.esc_attr(get_bloginfo('name')).'">'."\n";
  $meta .= '<meta property="og:description" content="'.esc_attr(get_bloginfo('description')).'">'."\n";
  $meta .= '<meta property="og:type" content="website">' . "\n";
  $meta .= '<meta property="og:url" content="'.esc_url(home_url()).'">' . "\n";
  $meta .= '<meta property="og:image" content="'.esc_url(get_field('main_img', get_posts(array('post_type' => 'header_img'))[0]->ID)).'">' . "\n";
  $meta .= '<meta property="og:site_name" content="'.esc_attr(get_bloginfo('name')).'" />'."\n";

  echo $meta;
}
add_action('wp_head','add_my_ogp');

/******************************************************************************************************************************************
*スタイルの読み込み
******************************************************************************************************************************************/
function add_my_style() {
  wp_enqueue_style('por_bootstrap-c', get_template_directory_uri().'/css/bootstrap-4.3.1.css', array(), '4.1.3');
  wp_enqueue_style('por_style', get_stylesheet_uri("style.css"));
}

add_action('wp_enqueue_scripts', 'add_my_style');

/******************************************************************************************************************************************
*スクリプトの読み込み
******************************************************************************************************************************************/
function add_my_script() {
  wp_deregister_script('jquery');
  wp_enqueue_script('por_jquery', get_template_directory_uri().'/js/jquery-3.3.1.min.js', array());
  wp_enqueue_script('por_popper', get_template_directory_uri().'/js/popper.min.js', array());
  wp_enqueue_script('por_bootstrap-j', get_template_directory_uri().'/js/bootstrap-4.3.1.js', array());
  wp_enqueue_script('por_page', get_template_directory_uri().'/js/page.js', array());
}
add_action('wp_footer', 'add_my_script');

/******************************************************************************************************************************************
*メールの送信
******************************************************************************************************************************************/
function portfolio_send_mail() {
  $args = array(
   'post_type' => 'contact' ,//投稿タイプ名
  );
  $contact = get_posts($args);
  $contact_info = $contact[0];

  $result = "" ;
  $display_none = "";
  $errorMessage = '';

  if(isset($_POST["submit_contact"])){

    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], -1)) {
      echo "<script type='text/javascript'>alert('メールの送信に失敗しました。もう一度やり直してください。');</script>";
      exit;
    }

    if (!empty($_POST["name"]) && !empty($_POST["mailadress"]) && !empty($_POST["inquiry"])) {

      $name =  htmlspecialchars($_POST["name"], ENT_QUOTES);
      $mailadress =  htmlspecialchars($_POST["mailadress"], ENT_QUOTES);
      $inquiry =  htmlspecialchars($_POST["inquiry"], ENT_QUOTES);

      if (preg_match( "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$/", $mailadress)) {

        date_default_timezone_set("Asia/Tokyo") ;
        mb_language("Japanese");
        mb_internal_encoding ("UTF-8");

        $time = date("Y年m月d日 H時i分", time());
        $body = "
        お問い合わせ日時  :  {$time}
        メールアドレス  :  {$mailadress}
        お名前  :  {$name}
        お問い合わせ内容  :  {$inquiry}
        " ;

        $mailto = $mailadress;
        $subject = esc_html(get_field('subject_interrogator', $contact_info->ID));
        $header = "from: ".esc_html(get_field('header_interrogator', $contact_info->ID));
        $mtaopt = "-f ".esc_html(get_field('header_interrogator', $contact_info->ID));
        $return1 = mb_send_mail ($mailto, $subject, $body ,$header, $mtaopt) ;
        // var_dump($mailto);
        // var_dump($subject);
        // var_dump($header);
        // var_dump($mtaopt);
        // var_dump($return1);

        $mailto = esc_html(get_field('mailto_administrator', $contact_info->ID));
        $subject = esc_html(get_field('subject_administrator', $contact_info->ID));
        $header = "from: ".esc_html(get_field('header_administrator', $contact_info->ID));
        $mtaopt = "-f ".esc_html(get_field('header_administrator', $contact_info->ID));
        $return2 = mb_send_mail ($mailto, $subject, $body, $header, $mtaopt) ;
        // var_dump($mailto);
        // var_dump($subject);
        // var_dump($header);
        // var_dump($mtaopt);
        // var_dump($return2);

        if ($return1 && $return2) {
          echo "<script type='text/javascript'>alert('お問い合わせありがとうございました。');</script>";
        } else {
          echo "<script type='text/javascript'>alert('メールの送信に失敗しました。もう一度やり直してください。');</script>";
        }
      }else {
        $errorMessage = "正しいメールアドレスを入力してください。";}
      }
    }
}


