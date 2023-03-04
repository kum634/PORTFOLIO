<section id="personality" class="pl-2 pr-2 contents_works current_position">
  <div class="container">
    <?php

    $post_name = 'personality';
    $args = array(
       'post_type' =>  $post_name,//投稿タイプ名
     );

     $personality_posts = get_posts($args);
     $cnt = 0;
     $icon_cnt = 0;
     ?>

     <style>
    <?php if ($personality_posts) : foreach ($personality_posts as $post) : ?>
      <?php
      $icon_cnt++;
      $class_name = $post_name.'_icon';
      ?>
     .<?php echo $class_name.$icon_cnt ?>::before {
      content: '<?php echo the_field('icon', $post->ID); ?>';
      font-family: "Font Awesome 5 Free";
      font-size: 4.5rem;
      padding: 20px;
      color: #000;
      filter: drop-shadow(2px 2px 2px rgb(0 0 0 / 30%));
     }
    <?php endforeach; ?>
  </style>
    <?php endif; ?>

     <h2>PERSONALITY</h2>
     <div class="row">
   <?php $icon_cnt = 0; ?>
   <?php if ($personality_posts) : foreach ($personality_posts as $post) : ?>
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
            <p><?php echo the_field('details', $post->ID); ?></p>
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
