<section id="works" class="pl-2 pr-2 contents_works current_position">
  <div class="container">
    <?php

    $post_name = 'works';
    $args = array(
       'post_type' =>  $post_name,//投稿タイプ名
     );

     $works_posts = get_posts($args);
     $cnt = 0;
     $icon_cnt = 0;
     ?>

     <style>
    <?php if ($works_posts) : foreach ($works_posts as $post) : ?>
      <?php
      $icon_cnt++;
      $class_name = $post_name.'_icon';
      ?>
     .<?php echo $class_name.$icon_cnt ?>::before {
      content: '<?php the_field('icon', $post->ID); ?>';
      font-family: "Font Awesome 5 Free";
      font-size: 4.5rem;
      font-weight: bold;
      padding: 20px;
      color: #212529;
      filter: drop-shadow(2px 2px 2px rgb(0 0 0 / 30%));
     }
    <?php endforeach; ?>
  </style>
    <?php endif; ?>

     <h2>WORKS</h2>
     <div class="row">
   <?php $icon_cnt = 0; ?>
   <?php if ($works_posts) : foreach ($works_posts as $post) : ?>
     <?php
     $icon_cnt++;
     $class_name = $post_name.'_icon';
     ?>
    <?php if ($cnt !=0 && $cnt%2 == 0) : ?>
    </div>
    <div class="row pl-2 pr-2">
    <?php endif; ?>
      <div class="col-md-6 p-2">
        <div class="card">
          <span class="mb-3 img_icon <?php echo $class_name.$icon_cnt ?>"></span>
          <h3 class="mb-3"><?php echo esc_html($post->post_title); ?></h3>
          <div class="p-3">
            <ul class="characteristic mb-0">
              <?php
              $list_mrk = mb_substr(esc_html(get_field('details', $post->ID)), 0, 1);
              $list = explode($list_mrk, esc_html(get_field('details', $post->ID)));
              foreach ($list as $val) {
                if ($val != '') echo '<li>'.$val.'</li>';
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
      <?php $cnt++; ?>
      <?php endforeach; ?>
    </div>
    <?php endif;
    wp_reset_postdata();
    ?>
  </div>
</section>
