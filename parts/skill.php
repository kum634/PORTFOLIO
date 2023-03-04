<section id="skill" class="pt-5 pb-5 contents_skill current_position">
  <h2>SKILL</h2>
  <div class="container">
    <div class="skill_wrap">


    <?php
    $taxonomyName = "skill_type";
    $skill_parents = array();
    //親ID取得
    $parent_terms = get_terms($taxonomyName, ['parent' => 0]);
    foreach ($parent_terms as $term) $skill_parents[] = $term->term_id;
    ?>

    <?php if ($skill_parents) : foreach($skill_parents as $parent_id) : ?>
    <?php
    if ($parent_id == 11 ) continue;
    //各親IDから子IDを取得
    $skill_childs = get_term_children($parent_id, $taxonomyName);
    ?>

    <div class="skill-tab">
      <?php $skill_tab_cnt = 1; ?>
        <?php if ($skill_childs) : foreach($skill_childs as $skill_child) : ?>
          <label class="<?php if ($skill_tab_cnt == 1) echo 'active' ; ?>"><?php echo esc_html(get_term($skill_child)->name); ?></label>
          <?php $skill_tab_cnt++; ?>
        <?php endforeach;endif;?>
    </div>
    <div class="skill-panel-wrap pr-0 pl-0 card">
    <?php
    $skill_tab_cnt = 1;
    $skill_posts_all = array();
    ?>
    <?php if ($skill_childs) : foreach($skill_childs as $skill_child) : ?>
    <?php
    $term_obj = get_term($skill_child);
    $args = array(
       'post_type' => 'skill' ,//投稿タイプ名
       // 'meta_key' => 'order',
       // 'orderby' => 'meta_value_num',
       'posts_per_page' => '10',
       'order' => 'ASC',
       'tax_query'      => array(
          array(
            'taxonomy' => $taxonomyName,  // カスタムタクソノミー名
            'field'    => 'slug',  // ターム名を term_id,slug,name のどれで指定するか
            'terms'    => $term_obj->slug // タクソノミーに属するターム名
          )
        )
     );

     $term_name = '';
     $skill_posts = get_posts($args);
     $skill_posts_all[] = $skill_posts;
     $cnt = 0;
     if (!$skill_posts) continue;
     ?>

  <?php if ($term_name == '') :?>


    <?php $term_name = $skill_child->name; ?>
  <?php endif ?>
    <div class="skill-panel<?php if ($skill_tab_cnt == 1) echo ' active' ; ?>">
     <div class="row">
   <?php if ($skill_posts) : foreach($skill_posts as $post) : setup_postdata( $post ); ?>
     <?php if ($cnt !=0 && $cnt%2 == 0) : ?>
      </div>
      <div class="skills_row row">
      <?php endif; ?>
        <div class="col-12">
        <!-- <div class="col-lg-6 col-md-6 col-sm-12"> -->
          <div class="card html_icon skill">
            <div class="skill_row align-items-center row mt-2 mb-2">
              <div class="col-4">
                <h3 class="mr-3"><?php echo esc_html($post->post_title); ?></h3>
              </div>
              <div class="col-4">
                <p class="stars">
                  <?php $level = esc_html(get_field('level', $post->ID)); ?>
                  <?php
                  for ($i=0; $i < $level; $i++) {
                    echo '<i class="fas fa-star"></i>';
                  }
                  for ($i=0; $i < 5 - $level; $i++) {
                    echo '<i class="far fa-star"></i>';
                  }
                  ?>
                </p>
              </div>
              <div class="skill_col_btn col-4">
                <button data-toggle="modal" data-target="#modal<?php echo esc_attr($post->ID); ?>" class="text-center mb-0 ml-auto btn btn-sm btn-outline-primary text-center">詳細</button>
                <!-- <button data-toggle="modal" data-target="#modal" class="ml-auto btn btn-sm btn-outline-primary text-center"><p class="btn-txt text-center overview mb-0">詳細</p></button> -->
              </div>
            </div>
          </div>
        </div>

    <?php
    $cnt++;
    $skill_count++;
    $skill_tab_cnt++;
    ?>
    <?php endforeach; ?>

  </div>
  <?php endif;
  wp_reset_postdata(); //クエリのリセット
  ?>
</div>


    <?php endforeach; ?>
    <?php endif; ?>

    <?php endforeach; ?>
    <?php endif; ?>
      </div>
    </div>
  </div>
  <!-- モーダルスペース -->
  <?php if ($skill_posts_all) : foreach($skill_posts_all as $skill_posts) : setup_postdata( $skill_posts ); ?>
  <?php if ($skill_posts) : foreach($skill_posts as $post) : setup_postdata( $post ); ?>
  <div class="modal fade" id="modal<?php echo esc_attr($post->ID); ?>" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content p-4">
        <h3 class="modal-title mt-2 mb-2"><?php echo esc_html($post->post_title); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-body">
          <div class="row pl-2 pr-2">
            <div class="col-12 pl-0 pr-0">
              <p class="text-center">以下のことが可能です。</p>
              <div class="skill_detail">
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
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; endif;?>
  <?php endforeach; endif;?>
  
  <!-- モーダルスペース -->
</section>
