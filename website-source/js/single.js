$(document).ready(function() {
  $('.game-content-btn').on( 'click', function() {
    $('.game-content-div').show();
    $('.game-download-div').hide();
  });
  $('.game-download-btn').on( 'click', function() {
    $('.game-content-div').hide();
    $('.game-download-div').show();
  });
});

//启动wangeditor编辑器
var editor = new wangEditor('comment');
editor.config.menus = [
    'bold',
    'underline',
    'italic',
    'strikethrough',
    'eraser',
    'forecolor',
    'bgcolor',
    'insertcode'
 ];    
editor.create();
//换行替换为列表，配合css代码显示行号
$("code, pre, .game-peizhi-div").each(function(){
  $(this).html("<ul><li>" + $(this).html().replace(/\n/g,"\n</li><li>") +"\n</li></ul>");
});
$('pre').addClass('hljs');
