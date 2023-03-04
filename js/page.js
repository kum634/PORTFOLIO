$(function(){

/*********************************************************************************************************************************
*タブの切り替え
**********************************************************************************************************************************/
  function skill_tab() {
    $(".skill-tab label").on("click",function(){
    	var $th = $(this).index();
    	$(".skill-tab label").removeClass("active");
    	$(".skill-panel-wrap .skill-panel").removeClass("active");
    	$(this).addClass("active");
    	$("#skill .skill-panel").eq($th).addClass("active");
    });
  }
  skill_tab();

  function portfolio_tab() {
    $(".portfolio-tab label").on("click",function(){
    	var $th = $(this).index();
    	$(".portfolio-tab label").removeClass("active");
    	$(".portfolio-panel-wrap .portfolio-panel").removeClass("active");
    	$(this).addClass("active");
    	$("#portfolio .portfolio-panel").eq($th).addClass("active");
    });
  }
  portfolio_tab();

  /*********************************************************************************************************************************
  アニメーション
  **********************************************************************************************************************************/

  $(function () {
    setTimeout(internal_animation(), 1600); //アニメーションを実行
  });

  function internal_animation() {
      $('#internal_btn').animate({
          marginTop: '-10px'
      }, 800).animate({
          marginTop: '+10px'
      }, 800);
      setTimeout(internal_animation(), 1600); //アニメーションを繰り返す間隔
  }


  $(window).scroll(function () {
    // var pos = $('#contents').offset().top;
    var pos = 0;
    var bgcolor = '#222c';
    console.log(pos);
    if ($(window).width() > 991) { bgcolor = 'none'; }
    if ( $(this).scrollTop() > pos ) {
      $('nav').css({
        background: '#222c',
        position: 'fixed',
      });
    } else {
      $('nav').css({
        background: bgcolor,
        position: 'absolute',
      });
    }
  });

  /*********************************************************************************************************************************
  *内部遷移アニメーション
  **********************************************************************************************************************************/

  function internal_transition() {
    $('a[href^="#"]').click(function() {
      var speed = 1500;
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      $('body,html').animate({scrollTop:position}, speed, 'swing');
      return false;
    });
  }
  internal_transition();

  /*********************************************************************************************************************************
  ホバーアニメーション
  **********************************************************************************************************************************/

  function card_hover_zoom() {
    // $('.hover_zoom').hide();
    $('.hover_trg').hover(function(){
      $(this).children('.hover_zoom').show();
      $(this).css('background-size','120%');
    },
    function(){
      // $(this).children('.hover_zoom').hide();
      $(this).css('transition','ease-in .3s')
      .css('background-size','100%');
    });
  }
  card_hover_zoom();

  /*********************************************************************************************************************************
  *画像の切り替え
  **********************************************************************************************************************************/

  function image_switching() {
    $('.modal-dialog close').on('click',function(){
      $('#mainImg img').attr('src', '');
    });

    $('#subImg li > div > div').on('click',function(){

      var img = '';
      var main_img = '';
      var arr = '';

      var cnt = 0;
      var h = 0;
      var new_h = 0;

      img = $(this).attr('style');
      main_img = $(this).parent().parent().parent().parent().find('#mainImg').children('img');
      h = main_img.parent().height();

      arr = img.split('(');
      arr = arr[1].split(')');

      $('#subImg li').removeClass('current');
      $(this).parent().parent().addClass('current');

      main_img.parent().height(h);
      main_img.hide( function() {
        main_img.attr('src', arr[0]).on('load', function() {
          $(this).show(function() {
            var a = main_img.parent().height();
            var b = main_img.height();
            // console.log('<div> new' + a);
            // console.log('<img> new' + b);
            main_img.parent().height(main_img.height());
          });
        });
      });
    });
  }
  image_switching();

  /*********************************************************************************************************************************
  *要素の高さ補正
  **********************************************************************************************************************************/

	function unification_height(card) {
		var max_height = 0;
		var height = 0;
		card.each(function(i, elem) {
			height = $(elem).height();
			if (max_height < height) max_height = height;
		});
		card.height(max_height);
	}
	// unification_height($('#works .card'));
	unification_height($('#personality .card'));

  function fixed_panel_hight(panel_classname) {
    $(function (){
      // console.log(panel_classname);
      var h = 0;
      var most_h = 0;
      var thisclass = '';
      var cnt = 0;
      $(panel_classname).each(function(){
        h = $(this).height();
        if (cnt < 1 || h > most_h) most_h = h;
        $(this).parent().height(most_h);
        // console.log(cnt);
        // console.log(most_h);
        cnt++;
      });
    });
  }
  fixed_panel_hight('.skill-panel-wrap .skill-panel');
  fixed_panel_hight('.portfolio-panel-wrap .portfolio-panel');

  /*********************************************************************************************************************************
  *スクロールアニメーション
  **********************************************************************************************************************************/

  function scroll_animate() {
    $(window).on('load resize scroll',function (){
      $('.card').each(function(){
        var target = $(this).offset().top;
        var scroll = $(window).scrollTop();
        var height = $(window).height();
        if (scroll > target - height){
          $(this).addClass('active');
        }
      });
    });
  }
  scroll_animate();
  /*********************************************************************************************************************************
  *カレント表示
  **********************************************************************************************************************************/
  $(function () {
    var set = $(window).height() - 500;//ウインドウ上部からどれぐらいの位置で変化させるか
    var boxTop = new Array;
    var current = -1;
    //各要素の位置
    // current_positionは場所を取得したい対象の要素に付ける
    boxTop[0] = 0;
    $('.current_position').each(function (i) {
      boxTop[i + 1] = $(this).offset().top;
    });
    //最初の要素にclass="positiion-now"をつける
    changeBox(0);
    //スクロールした時の処理
    $(window).scroll(function () {
      scrollPosition = $(window).scrollTop();
      for (var i = boxTop.length - 1; i >= 0; i--) {
        if ($(window).scrollTop() > boxTop[i] - set) {
          changeBox(i);
          break;
        }
      };
    });
    //ナビの処理
    function changeBox(secNum) {
      if (secNum != current) {
        current = secNum;
        secNum2 = secNum + 1;//以下にクラス付与したい要素名と付与したいクラス名
        $('header nav ul li a').removeClass('link-current');
  
        if (current == 0) {
          $('a[href="#top"]').addClass('link-current');
        } else if (current == 1) {
          $('a[href="#about"]').addClass('link-current');
        } else if (current == 2) {
          $('a[href="#works"]').addClass('link-current');
        } else if (current == 3) {
          $('a[href="#portfolio"]').addClass('link-current');
        } else if (current == 4) {
          $('a[href="#skill"]').addClass('link-current');
        } else if (current == 5) {
          $('a[href="#personality"]').addClass('link-current');
        } else if (current == 6) {
          $('a[href="#contact"]').addClass('link-current');
        }
  
      }
    };
  });

  /*********************************************************************************************************************************
  *バリデート
  **********************************************************************************************************************************/

  function validate() {
    $('#form-contact button').on('click' , function() {

      var error_flg = 0;
      var er_mailaddress = $('.error_mailaddress');
      var er_name = $('.error_name');
      var er_inquiry = $('.error_inquiry');

      er_mailaddress.text('');
      er_name.text('');
      er_inquiry.text('');

      var mailaddress = $('#mailadress').val();
      var name = $('#name').val();
      var inquiry = $('#inquiry').val();

      if (!mailaddress) {
        er_mailaddress.text('メールアドレスが入力されていません。');
        error_flg = 1;
      } else if (!mailaddress.match(/.+@.+\..+/)) {
        er_mailaddress.text('正しい形式で入力してください。');
        error_flg = 1;
      }
      if (!name) {
        er_name.text('お名前が入力されていません。');
        error_flg = 1;
      }
      if (!inquiry) {
        er_inquiry.text('お問い合わせ内容が入力されていません。');
        error_flg = 1;
      }

      if (error_flg == 1) return false;
      $('#form-contact').submit();
    });
  }
  validate();

  /*********************************************************************************************************************************
  *その他補正
  **********************************************************************************************************************************/

  if ($('#skill').css("background-color") == "rgb(243, 245, 247)") {
    $('#skill .skill-tab label').css({
      'background': 'rgb(255, 255, 255)'
    });
  } else if ($('#skill').css("background-color") == "rgb(255, 255, 255)") {
    $('#skill .skill-tab label').css({
      'background': 'rgb(0 0 0 / 10%)'
    });
  }

  if ($('#portfolio').css("background-color") == "rgb(243, 245, 247)") {
    $('#portfolio .portfolio-tab label').css({
      'background': 'rgb(255, 255, 255)'
    });
  } else if ($('#portfolio').css("background-color") == "rgb(255, 255, 255)") {
    $('#portfolio .portfolio-tab label').css({
      'background': 'rgb(0 0 0 / 10%)'
    });
  }




});
