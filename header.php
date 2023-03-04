<!DOCTYPE html>
<html>
<head>
<title>
<?php bloginfo('name'); ?>
</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no,noindex,nofollow,noarchive">
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

<?php wp_head(); ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-8GXW833NH3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8GXW833NH3');
</script>
</head>
<body>
<div id="page">
  <?php
  $args = array(
     'post_type' => 'header_img' ,//投稿タイプ名
   );

   $about_post = get_posts($args);
   $post = $about_post[0];
   ?>
  <style>
  header:before {
    content: "";
    display: block;
    background: url('<?php the_field('main_img', $post->ID); ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1;
  }
  </style>
  <header id="top" class="site-header">
    <div class="text-center pt-0 pb-0">
      <nav class="navbar navbar-expand-lg navbar-dark custom-hamburger">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span><span class="navbar-toggler-icon"></span><span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item"> <a class="nav-link" href="#top">TOP<span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link" href="#about">ABOUT<span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link" href="#works">WORKS<span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link" href="#portfolio">PORTFOLIO<span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link" href="#skill">SKILL<span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link" href="#personality">PERSONALITY<span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link" href="#contact">CONTACT<span class="sr-only">(current)</span></a> </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
          </form>
        </div>
      </nav>

      <?php if (get_field('main_img', $post->ID)) : ?>
      <div class="d-flex header_filter">
        <div class="top_title text-center">
          <h1 class="mb-4 text-center"><?php the_field('main_taitle', $post->ID); ?></h1>
          <h2 class="text-center"><?php the_field('sub_title_1', $post->ID); ?></h2>
          <button id="internal_btn" class="text-center"><a  href="#contents"><p class="text-center mb-0"><i class="fas fa-angle-down"></i></p></a></button>
        </div>
      </div>
    <?php endif;
    wp_reset_postdata();
    ?>
    </div>
  </header>
<div id="contents" class="text-center">
