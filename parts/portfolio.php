<?php
$args = array(
  'post_type' => 'private_achievement' ,//投稿タイプ名
  'posts_per_page' => 6,
  // 'meta_key' => 'order',
  // 'orderby' => 'meta_value_num',
  'order' => 'ASC'
  // 'tax_query'      => array(
  //    array(
  //      'taxonomy' => $taxonomyName,  // カスタムタクソノミー名
  //      'field'    => 'slug',  // ターム名を term_id,slug,name のどれで指定するか
  //      'terms'    => $term->slug // タクソノミーに属するターム名
  //    )
  //  )
);
$private_posts = get_posts($args);

$args = array(
  'post_type' => 'accept_achievement' ,//投稿タイプ名
  'posts_per_page' => 6,
  // 'meta_key' => 'order',
  // 'orderby' => 'meta_value_num',
  'order' => 'ASC'
  // 'tax_query'      => array(
  //    array(
  //      'taxonomy' => $taxonomyName,  // カスタムタクソノミー名
  //      'field'    => 'slug',  // ターム名を term_id,slug,name のどれで指定するか
  //      'terms'    => $term->slug // タクソノミーに属するターム名
  //    )
  //  )
);
$accept_posts = get_posts($args);

if (!$accept_posts && !$private_posts) return;

$portfolio_captions = array(
  'private_achievement' => '個人',
  'accept_achievement' => '受諾'
);
?>
<section id="portfolio" class="pt-5 pb-5 contents_portfolio current_position">
  <h2>PORTFOLIO</h2>
  <div class="container">
    <div class="portfolio_wrap">

     <?php if (count($accept_posts ) > 0) : ?>
     <div class="portfolio-tab">
       <?php $portfolio_tab_cnt = 0; ?>
       <?php $active = ''; ?>
       <?php foreach($portfolio_captions as $key => $caption) : ?>
         <?php
         if (count(get_posts(array('post_type' => $key))) > 0) $portfolio_tab_cnt++;
         if ($active == '' && $portfolio_tab_cnt == 1) $active = 'active';
         else $active = '';
         ?>
         <label class="<?php echo $active; ?>"><?php echo $portfolio_captions[$key]; ?></label>
       <?php endforeach; ?>
     </div>
     <?php endif; ?>

     <div class="portfolio-panel-wrap card">
    <!-- 投稿が存在する場合 サムネイルとリンクを表示 -->
    <?php $portfolio_tab_cnt = 0; ?>
    <?php $active = ''; ?>

    <!-- 個人 -->
      <?php
      if (count($private_posts ) > 0) $portfolio_tab_cnt++;
      if ($active == '' && $portfolio_tab_cnt == 1) $active = ' active';
      else $active = '';
      ?>
      <div class="portfolio-panel<?php echo $active; ?>">
          <?php if ($private_posts) : ?>

          <?php $cnt = 0; ?>
            <div class="row">
          <?php foreach($private_posts as $post) : setup_postdata( $post ); ?>
            <?php if ($cnt !=0 && $cnt%2 == 0) : ?>
            </div>
            <div class="row">
            <?php endif; ?>
          <div class="col-md-6 mb-4 pl-3 pr-3 portfolio_bg">
            <div class="img_wrap card p-0">
              <div data-toggle="modal" data-target="#modal<?php echo esc_attr($post->ID); ?>" style="<?php if (!empty(get_field('thumbnail_img', $post->ID))) echo 'background-image: url('.esc_url(get_field('thumbnail_img', $post->ID)).')'; ?>" class="hover_trg portfolio_img">
                <div class="hover_zoom">
                  <h3 class="mb-0"><?php echo wp_kses_post(str_replace(" ", "<br>", $post->post_title)); ?></h3>
                  <!-- <p class="text-center m-0 pr-2 pl-2 overview">
                    [<?php the_field('technology_used', $post->ID); ?>]
                  </p> -->
                </div>
              </div>
            </div>
            <div class="mb-0">
              <p class="text-right mt-2 mb-0" style="font-size:1rem;">画像クリックで詳細を表示</p>
              <?php if (!empty(get_field('github', $post->ID))) { ?>
                <p class="text-right mb-0" style="font-size:1rem;">Github : <a target=”blank” style="color:#007bff;" href="<?php the_field('github', $post->ID); ?>"><i class="fab fa-github github_icon"></i> <?php echo mb_substr(esc_url(get_field('github', $post->ID)), mb_strrpos(esc_url(get_field('github', $post->ID)), '/') + 1); ?></a></p>
              <?php } ?>
            </div>
          </div>
          <?php $cnt++; ?>
        <?php endforeach; ?>
        </div>

      <?php endif; ?>
    </div>
  <!-- 個人 -->

  <!-- 受諾 -->
    <?php
    if (count($accept_posts ) > 0) $portfolio_tab_cnt++;
    if ($active == '' && $portfolio_tab_cnt == 1) $active = ' active';
    else $active = '';
    ?>
    <div class="portfolio-panel<?php echo $active; ?>">
      <?php if ($accept_posts) : ?>

        <?php $cnt = 0; ?>
        <div class="row">
        <?php foreach($accept_posts as $post) : setup_postdata( $post ); ?>
        <?php if ($cnt !=0 && $cnt%2 == 0) : ?>
        </div>
        <div class="row">
        <?php endif; ?>
          <div class="col-md-6 mb-4 pl-3 pr-3 portfolio_bg">
            <div class="img_wrap card p-0">
              <div data-toggle="modal" data-target="#modal<?php echo esc_attr($post->ID); ?>" style="<?php if (!empty(get_field('thumbnail_img', $post->ID))) echo 'background-image: url('.esc_url(get_field('thumbnail_img', $post->ID)).')'; ?>" class="hover_trg portfolio_img">
                <div class="hover_zoom">
                  <h3 class="mb-0"><?php echo wp_kses_post(str_replace(" ", "<br>", $post->post_title)); ?></h3>
                  <!-- <p class="text-center pr-2 pl-2 overview">
                    [<?php the_field('technology_used', $post->ID); ?>]
                  </p> -->
                </div>
              </div>
            </div>
            <div class="mb-0">
              <p class="text-right mt-2 mb-0" style="font-size:1rem;">画像クリックで詳細を表示</p>
              <?php if (!empty(get_field('github', $post->ID))) { ?>
                <p class="text-right mb-0" style="font-size:1rem;">Github : <a target=”blank” style="color:#007bff;" href="<?php the_field('github', $post->ID); ?>"><i class="fab fa-github github_icon"></i> <?php echo mb_substr(esc_url(get_field('github', $post->ID)), mb_strrpos(esc_url(get_field('github', $post->ID)), '/') + 1); ?></a></p>
              <?php } ?>
            </div>
          </div>
        <?php $cnt++; ?>
      <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
  <!-- 受諾 -->

  <!-- 投稿が存在する場合 サムネイルとリンクを表示 ここまで -->
  </div>

  <?php if ($private_posts) : foreach($private_posts as $post) : setup_postdata( $post ); ?>
  <div class="modal fade" id="modal<?php echo esc_attr($post->ID); ?>" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <h3 class="modal-title"><?php echo esc_html($post->post_title); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-body">
          <div class="row pl-2 pr-2">
            <div class="col-12 pl-0 pr-0">
              <div class="portfolio_discription">
                <?php if (!empty(get_field('demo', $post->ID)) || !empty(get_field('github', $post->ID))) { ?>
                <div class="sm_dl">
                  <?php if (!empty(get_field('demo', $post->ID))) { ?>
                  <div class="overview d-flex">
                    <p class="overview mb-0 text-right" style="font-size:1rem;"><a target=”_blank” style="color:#0056b3;" href="<?php the_field('demo', $post->ID); ?>" target="_blank">外部サイトへ移動</a></p>
                  </div>
                  <?php } ?>
                  <?php if (!empty(get_field('github', $post->ID))) { ?>
                  <div class="overview mt-3 d-flex">
                    <p class="overview mb-0 text-right" style="font-size:1rem;"><a target=”_blank” style="color:#0056b3;" href="<?php the_field('github', $post->ID); ?>"><i class="fab fa-github github_icon"></i> <?php echo mb_substr(esc_url(get_field('github', $post->ID)), mb_strrpos(esc_url(get_field('github', $post->ID)), '/') + 1); ?></a></p>
                  </div>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="col-lg-6 pl-0 pr-0">
              <div class="portfolio_discription">
                <?php if (!empty(get_field('technology_used', $post->ID))) { ?>
                <dl>
                  <dt>使用技術</dt>
                  <dd>
                    <p class="text-left overview">
                      <?php the_field('technology_used', $post->ID); ?>
                    </p>
                  </dd>
                </dl>
                <?php } ?>
                <?php if (!empty(get_field('summary', $post->ID))) { ?>
                <dl>
                  <dt>概要</dt>
                  <dd>
                    <p class="text-left overview"><?php the_field('summary', $post->ID); ?></p>
                  </dd>
                </dl>
                <?php } ?>
              </div>
            </div>
            <div class="col-lg-6 pl-0 pr-0">
              <div class="portfolio_discription">
                <?php if (!empty(get_field('details', $post->ID))) { ?>
                <dl>
                  <dt>機能</dt>
                  <dd>
                    <ul class="characteristic">
                      <?php
                      //例 : 役割1(担当業務1、担当業務2 ・・・)
                      //例 : サーバーサイド側の開発(CURD機能実装、テスト ・・・)
                      $list_mrk = mb_substr(esc_html(get_field('details', $post->ID)), 0, 1);
                      $list = explode($list_mrk, esc_html(get_field('details', $post->ID)));
                      foreach ($list as $val) {
                        if ($val != '') echo '<li>'.$val.'</li>';
                      }
                      ?>
                    </ul>
                  </dd>
                </dl>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="row pl-4 pr-4">
            <div class="col-12 pl-0 pr-0 portfolio_bg" style="background:#FFF;">
              <?php

              $img_arr = array();
              $img_cnt = 2;
              $flg = 0;
              for ($i = 1; $i < $img_cnt; $i++) {
                //二枚目の画像が無い場合
                if (empty(get_field('img_2', $post->ID))) break;
                $filed_name = 'img_'.$i;
                if ($filed_name == 'img_1' && !empty(get_field($filed_name, $post->ID))) {
                  $flg = 1;
                  echo '<ul id="subImg">';
                }
                //三枚目以降の画像が存在しない場合
                if (empty(get_field($filed_name, $post->ID))) {
                  if ($flg == 1) echo '</ul>';
                  break;
                }
                if ($filed_name == 'img_1' && !empty(get_field($filed_name, $post->ID))) echo '<li class="current">';
                else echo '<li>';
                echo '<div class="img_wrap card">';
                echo '<div style="background-image: url('.esc_url(get_field($filed_name, $post->ID)).')" class=" portfolio_img"></div>';
                echo '</div>';
                echo '</li>';
                $img_cnt++;
              }
              // if (is_user_logged_in()){
              //         global $wpdb,$post;
              //         $sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=" . $post->ID;
              //         $results = $wpdb->get_results( $sql, OBJECT );
              //         print_r($results);
              //     }
               ?>
             <?php if (!empty(get_field('img_1', $post->ID))) { ?>
               <div id="mainImg" class="">
                 <img src="<?php the_field('img_1', $post->ID); ?>">
               </div>

             <?php } ?>
             <?php
                 // if (is_user_logged_in()){
                 //     global $wpdb,$post;
                 //     $sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=" . $post->ID;
                 //     $results = $wpdb->get_results( $sql, OBJECT );
                 //     print_r($results);
                 // }
             ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php endforeach; ?>
  <?php endif;
  wp_reset_postdata(); //クエリのリセット
  ?>


  <!-- 投稿が存在する場合 詳細を表示 -->
  <?php if ($accept_posts) : foreach($accept_posts as $post) : setup_postdata( $post ); ?>
  <div class="modal fade" id="modal<?php echo esc_attr($post->ID); ?>" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <h3 class="modal-title"><?php echo esc_html($post->post_title); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-body">
          <div class="row pl-2 pr-2">
            <div class="col-12 pl-0 pr-0">
              <div class="portfolio_discription">
                <?php if (!empty(get_field('demo', $post->ID)) || !empty(get_field('github', $post->ID))) { ?>
                <div class="sm_dl">
                  <?php if (!empty(get_field('demo', $post->ID))) { ?>
                  <div class="overview d-flex">
                    <p class="overview mb-0 text-right" style="font-size:1rem;"><a target=”_blank” style="color:#0056b3;" href="<?php the_field('demo', $post->ID); ?>" target="_blank">外部サイトへ移動</a></p>
                  </div>
                  <?php } ?>
                  <?php if (!empty(get_field('github', $post->ID))) { ?>
                  <div class="overview mt-3 d-flex">
                    <p class="overview mb-0 text-right" style="font-size:1rem;"><a target=”_blank” style="color:#0056b3;" href="<?php the_field('github', $post->ID); ?>"><i class="fab fa-github github_icon"></i> <?php echo mb_substr(esc_url(get_field('github', $post->ID)), mb_strrpos(esc_url(get_field('github', $post->ID)), '/') + 1); ?></a></p>
                  </div>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="col-lg-6 pl-0 pr-0">
              <div class="portfolio_discription">
                <?php if (!empty(get_field('technology_used', $post->ID))) { ?>
                <dl>
                  <dt>使用技術</dt>
                  <dd>
                    <p class="text-left overview">
                      <?php the_field('technology_used', $post->ID); ?>
                    </p>
                  </dd>
                </dl>
                <?php } ?>
                <?php if (!empty(get_field('summary', $post->ID))) { ?>
                <dl>
                  <dt>概要</dt>
                  <dd>
                    <p class="text-left overview"><?php the_field('summary', $post->ID); ?></p>
                  </dd>
                </dl>
                <?php } ?>
              </div>
            </div>
            <div class="col-lg-6 pl-0 pr-0">
              <div class="portfolio_discription">
                <?php if (!empty(get_field('details', $post->ID))) { ?>
                <dl>
                  <dt>機能</dt>
                  <dd>
                    <ul class="characteristic">
                      <?php
                      //例 : 役割1(担当業務1、担当業務2 ・・・)
                      //例 : サーバーサイド側の開発(CURD機能実装、テスト ・・・)
                      $list_mrk = mb_substr(esc_html(get_field('details', $post->ID)), 0, 1);
                      $list = explode($list_mrk, esc_html(get_field('details', $post->ID)));
                      foreach ($list as $val) {
                        if ($val != '') echo '<li>'.$val.'</li>';
                      }
                      ?>
                    </ul>
                  </dd>
                </dl>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="row pl-4 pr-4">
            <div class="col-12 pl-0 pr-0 portfolio_bg" style="background:#FFF;">
              <?php

              $img_arr = array();
              $img_cnt = 2;
              $flg = 0;
              for ($i = 1; $i < $img_cnt; $i++) {
                //二枚目の画像が無い場合
                if (empty(get_field('img_2', $post->ID))) break;
                $filed_name = 'img_'.$i;
                if ($filed_name == 'img_1' && !empty(get_field($filed_name, $post->ID))) {
                  $flg = 1;
                  echo '<ul id="subImg">';
                }
                //三枚目以降の画像が存在しない場合
                if (empty(get_field($filed_name, $post->ID))) {
                  if ($flg == 1) echo '</ul>';
                  break;
                }
                if ($filed_name == 'img_1' && !empty(get_field($filed_name, $post->ID))) echo '<li class="current">';
                else echo '<li>';
                echo '<div class="img_wrap card">';
                echo '<div style="background-image: url('.esc_url(get_field($filed_name, $post->ID)).')" class=" portfolio_img"></div>';
                echo '</div>';
                echo '</li>';
                $img_cnt++;
              }
              // if (is_user_logged_in()){
              //         global $wpdb,$post;
              //         $sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=" . $post->ID;
              //         $results = $wpdb->get_results( $sql, OBJECT );
              //         print_r($results);
              //     }
               ?>
             <?php if (!empty(get_field('img_1', $post->ID))) { ?>
               <div id="mainImg" class="">
                 <img src="<?php the_field('img_1', $post->ID); ?>">
               </div>

             <?php } ?>
             <?php
                 // if (is_user_logged_in()){
                 //     global $wpdb,$post;
                 //     $sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=" . $post->ID;
                 //     $results = $wpdb->get_results( $sql, OBJECT );
                 //     print_r($results);
                 // }
             ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php endforeach; ?>
  <?php endif;
  wp_reset_postdata(); //クエリのリセット
  ?>

  <!-- 投稿が存在する場合 詳細を表示 ここまで -->

  </div>
</section>
