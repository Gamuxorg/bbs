	</div>
  </div>
  </div>
	<footer class="footer site-footer w-100">
		<div class="site-footer-div">
			<ul class="footer-ul nav justify-content-center">
				<li class="nav-item">GitHub</li>
				<li class="nav-item">Git@OSC</li>
				<li class="nav-item">About</li>
				<li class="nav-item">QQ群：274328087</li>
        <li class="clear"></li>
			</ul>
			<div class="footer-info text-center">
				<p>Made by Wordpress <?php echo get_bloginfo('version'); ?> with BootStrap 4</p>
        <p><?php echo get_bloginfo('description'); ?></p>
				<p>2012-<?php echo date('Y'); ?>, 简洁.现代.自由, Gamux, <a href="http://www.miitbeian.gov.cn/" rel="external nofollow" target="_blank"><?php echo get_option( 'zh_cn_l10n_icp_num' );?></a></p>
			</div>
		</div>
	</footer>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script>
//源码地址https://zhuanlan.zhihu.com/p/22936824
$(function(){
    function footerPosition(){
        $("footer").removeClass("fixed-bottom");
        var contentHeight = document.body.scrollHeight,
            winHeight = window.innerHeight;
        if(!(contentHeight > winHeight)){
            $("footer").addClass("fixed-bottom");
        } else {
            $("footer").removeClass("fixed-bottom");
        }
    }
    footerPosition();
    $(window).resize(footerPosition);
});
</script>
<?php if(is_single()) { ?>
<script src="https://cdn.bootcss.com/wangEditor/2.1.23/wangEditor.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/single.js"></script>
<?php } elseif( (strpos($_SERVER['REQUEST_URI'], 'gamelist') != false) || (is_category()) ) { ?>
<script src="https://cdn.bootcss.com/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>
<script>
//结合了wordpress的restAPI，筛选分类和分页，期待有人帮忙把php代码改为全js代码。
$.ajax({    
  url: '<?php echo site_url(); ?>/wp-json/wp/v2/posts',
  type: 'get',
  data: {'page': 1, 'per_page': 12<?php if(is_category()){echo", 'categories':". get_the_category()[0]->term_id; } ?>},
  dataType: 'json',    
  success: function(data) {
    $('.gamux-11').html('');
    $(data).each(function() {
      $('.gamux-11').append('<div class="media mb-3 col-6 col-lg-4"><a class="align-self-center md-mr-2 mr-2" href="'+ this['link'] +'"><img class="gamux-1-icon" src="'+ this['gmeta'][0] +'" alt="LOGO"></a><div class="media-body align-self-center"><div class="media-heading"><a class="" href="'+ this['link'] +'">'+this['title']['rendered']+'</a></div><div class="d-flex flex-column gamux-1-info"><span class="d-none d-sm-block gamux-1-author">'+this['gmeta'][5]+'</span><span class="d-none d-sm-block">版本：'+this['gmeta'][1]['version']+'</span></div></div></div>');  
    });
  },    
  error: function() {        
    $('.gamux-11').html('error!');    
  }    
});
$('#pagination').twbsPagination({
  totalPages: <?php if(is_category()){ echo ceil((get_the_category()[0]->count)/12);}else{ echo ceil((wp_count_posts()->publish)/12);} ?>,
  first: '<<',
  last: '>>',
  prev: '<',
  next: '>',
  visiblePages: 3,
  onPageClick: function (event, page) {
		$.ajax({    
			url: '<?php echo site_url(); ?>/wp-json/wp/v2/posts',
			type: 'get',
			data: {'page': page, 'per_page': 12<?php if(is_category()){echo", 'categories':". get_the_category()[0]->term_id; } ?>},
			dataType: 'json',    
			success: function(data) {
        $('.gamux-11').html('');
				$(data).each(function() {
          $('.gamux-11').append('<div class="media mb-3 col-6 col-lg-4"><a class="align-self-center md-mr-2 mr-2" href="'+ this['link'] +'"><img class="gamux-1-icon" src="'+ this['gmeta'][0] +'" alt="LOGO"></a><div class="media-body align-self-center"><div class="media-heading"><a class="" href="'+ this['link'] +'">'+this['title']['rendered']+'</a></div><div class="d-flex flex-column gamux-1-info"><span class="d-none d-sm-block gamux-1-author">'+this['gmeta'][5]+'</span><span class="d-none d-sm-block">版本：'+this['gmeta'][1]['version']+'</span></div></div></div>');  
        });
			},    
			error: function() {        
				$('.gamux-11').html('error!');    
			}    
		});
  }
});
$('.listgame-li a').on('click', function() {
var cateid = $(this).attr('categoryid');
var newtotalpages = 1;  
$.ajax({    
  url: '<?php echo site_url(); ?>/wp-json/wp/v2/posts',
  type: 'get',
  data: {'page': 1, 'per_page':12, 'categories': cateid},
  dataType: 'json',    
  success: function(data) {
    newtotalpages = data[0]['gmeta'][3];
    $('.gamux-11').html('');
    $(data).each(function() {
      $('.gamux-11').append('<div class="media mb-3 col-6 col-lg-4"><a class="align-self-center md-mr-2 mr-2" href="'+ this['link'] +'"><img class="gamux-1-icon" src="'+ this['gmeta'][0] +'" alt="LOGO"></a><div class="media-body align-self-center"><div class="media-heading"><a class="" href="'+ this['link'] +'">'+this['title']['rendered']+'</a></div><div class="d-flex flex-column gamux-1-info"><span class="d-none d-sm-block gamux-1-author">'+this['gmeta'][5]+'</span><span class="d-none d-sm-block">版本：'+this['gmeta'][1]['version']+'</span></div></div></div>');  
    });
    $('#pagination').twbsPagination('destroy');
    $('#pagination').twbsPagination({
      totalPages: Math.ceil(newtotalpages/12),
      first: '<<',
      last: '>>',
      prev: '<',
      next: '>',
      visiblePages: 3,
      onPageClick: function (event, page) {
        $.ajax({    
          url: '<?php echo site_url(); ?>/wp-json/wp/v2/posts',
          type: 'get',
          data: {'page': page, 'per_page': 12, 'categories': cateid},
          dataType: 'json',    
          success: function(data) {
            $('.gamux-11').html('');
            $(data).each(function() {
              $('.gamux-11').append('<div class="media mb-3 col-6 col-lg-4"><div class="row"><a class="align-self-center md-mr-2 mr-2" href="'+ this['link'] +'"><img class="gamux-1-icon" src="'+ this['gmeta'][0] +'" alt="LOGO"></a><div class="media-body align-self-center"><div class="media-heading"><a class="" href="'+ this['link'] +'">'+this['title']['rendered']+'</a></div><div class="d-flex flex-column gamux-1-info"><span class="d-none d-sm-block gamux-1-author">'+this['gmeta'][5]+'</span><span class="d-none d-sm-block">版本：'+this['gmeta'][1]['version']+'</span></div></div></div>');  
          });
          },    
          error: function() {        
            $('.cat-main').html('error!');    
          }    
        });
      }
    });
  },    
  error: function() {        
    $('.cat-main').html('error!');    
  }    
});     
});
</script>
<?php } else{} ?>
<?php wp_footer(); ?>
</body>
</html>