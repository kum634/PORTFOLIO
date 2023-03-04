<section id="contact" class="text-center contents_contact current_position">
  <div class="container">
    <h2>CONTACT</h2>
    <?php portfolio_send_mail(); ?>
    <form class="form-contact" action="" id="form-contact" name="form-signin" method="post">
      <p class="text-center mb-4">
        <?php
        $args = array(
          'post_type' => 'contact' ,//投稿タイプ名
        );
        $contact = get_posts($args);
        $contact_info = $contact[0];
        the_field('contact_heading', $contact_info->ID);
        wp_reset_postdata(); //クエリのリセット

        ?>
        <!-- 何かありましたら、ご連絡お待ちしております。 -->
      </p>
      <p style="color:#CC0003;" class="text-left error_mailaddress mb-0"></p>
      <label for="mailadress" class="sr-only">メールアドレス</label>
      <input type="mail" id="mailadress" class="form-control mb-4" placeholder="メールアドレス" name="mailadress">
      <p style="color:#CC0003;" class="text-left error_name mb-0"></p>
      <label for="name" class="sr-only">お名前</label>
      <input type="text" id="name" class="form-control mb-4" placeholder="お名前" name="name">
      <p style="color:#CC0003;" class="text-left error_inquiry mb-0"></p>
      <label for="inquiry" class="sr-only">お問い合わせ内容</label>
      <textarea id="inquiry" class="form-control mb-5" placeholder="お問い合わせ内容" name="inquiry" style="height: 200px;"></textarea>
      <button class="btn btn-lg btn-primary" name="submit_contact" type="submit">送信</button>
      <?php wp_nonce_field(); ?>
    </form>
  </div>
</section>
