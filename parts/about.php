<section id="about" class="contents_about current_position">
<?php
$args = array(
   'post_type' => 'about' ,//投稿タイプ名
 );

 $about_post = get_posts($args);
 $post = $about_post[0];

 $age = (time() - strtotime(esc_html(get_field('birthday', $post->ID)))) / (60*60*24*365);
?>

<?php if ($post) : ?>
  <div class="container">
    <h2>ABOUT</h2>
    <div class="row">
      <!-- <div class="col-md-6 pt-2 pb-2">
        <div class="my_photo"><img src="<?php the_field('photo', $post->ID); ?> " alt="MY_PHOTO"/></div>
      </div> -->
      <div class="col-12 pt-2 pb-2">
      <!-- <div class="col-md-6 pt-2 pb-2"> -->
        <ul class="card prof text-left">
          <li>年齢 : <?php echo floor($age); ?>歳</li>
          <!-- <li>名前 : <?php //the_field('name', $post->ID); ?></li> -->
          <!-- <li>生年月日 : <?php //the_field('birthday', $post->ID); ?>（<?php echo floor($age); ?>歳）</li> -->
          <li>出身 : <?php the_field('from', $post->ID); ?>（<?php the_field('current_address', $post->ID); ?>在住）</li>
          <li>略歴 : <?php the_field('history', $post->ID); ?></li>
          <li>その他 : <?php the_field('pr', $post->ID); ?></li>
        </ul>
      </div>
    </div>
  </div>
  <?php endif;
  wp_reset_postdata();
  ?>
  <?php

  $post_name = 'account_link';
  $args = array(
     'post_type' =>  $post_name,//投稿タイプ名
   );

   $account_link_posts = get_posts($args);
   $cnt = 0;
   $post_cnt = count($account_link_posts);
   // var_dump($post_cnt);
   ?>

  <?php if ($account_link_posts) : ?>
    <div class="row pl-2 pr-2">
  <?php foreach($account_link_posts as $post) : setup_postdata( $post ); ?>
  <?php if ($cnt == 6) break; ?>
    <?php if ($cnt !=0 && $cnt%2 == 0) : ?>
    </div>
    <div class="row pl-2 pr-2">
    <?php endif; ?>
      <?php if ($post_cnt == 1 || $post_cnt%3 == 1) : ?>
      <div class="col-12 pl-3 pr-3 portfolio_bg">
      <?php elseif ($post_cnt == 2 || $post_cnt%3 == 2) : ?>
      <div class="col-md-6 pl-3 pr-3 portfolio_bg">
      <?php elseif ($post_cnt == 3 || $post_cnt%3 == 0) : ?>
      <div class="col-md-4 pl-3 pr-3 portfolio_bg">
      <?php endif; ?>
        <a href="<?php the_field('url', $post->ID); ?>" class="mb-2 mt-2 img_icon"><?php the_field('icon', $post->ID); ?></a>
      </div>
  <?php $cnt++; ?>
  <?php endforeach; ?>
  </div>
<?php endif;
wp_reset_postdata();
?>
</section>
