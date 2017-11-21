jQuery(document).ready(function($) {
    var wrapper = $(".gamux-edit-upload-label");
    var add_button = $(".gamux-upload-add");
    $(add_button).on('click', function(e){
        e.preventDefault();
		count = $('.gamux-edit-upload-option').size();
		$(wrapper).append('<div class="gamux-edit-upload-option"><input type="text" placeholder="此处显示下载url，可粘贴外部url" name="downurl_'+count+'" class="gamux-up-input" /><input type="text" placeholder="版本说明"  name="dtitle_'+count+'" class="gamux-text-input extra-text-input" /><button type="button" class="gamux-up-button">上传</button><button type="button" class="gamux-upload-delete">-</button></div>');  
	}); 
    
    $(wrapper).on("click",".gamux-upload-delete", function(e){
        e.preventDefault(); 
		$(this).parents('.gamux-edit-upload-option').remove();
    });

var formfield_url = '';
var formfield_title = '';
var gamux_upload_frame;
$('.gamux-edit-upload-label').on('click', '.gamux-up-button',function() {
	event.preventDefault();
    formfield_url = $(this).prevAll('.gamux-up-input');
	formfield_title = $(this).prevAll('.gamux-text-input');
	if( gamux_upload_frame ){   
		gamux_upload_frame.open();   
		return;   
	}	
	gamux_upload_frame = wp.media({   
		title: '上传新文件',   
		button: {   
			text: '插入',   
		},   
		multiple: false   
	});   

	gamux_upload_frame.on('select',function(){   
		attachment =gamux_upload_frame.state().get('selection').first().toJSON();
		$(formfield_url).val(attachment.url);
		$(formfield_title).val(attachment.title);
		console.log(attachment);
	});   
	   
	gamux_upload_frame.open();
    });
//特色图片title修改
$('#postimagediv').children('h2').children('span').text('上传主题LOGO');
//分类设置，复选框变为单选框
$("#categorychecklist input, #categorychecklist-pop input, .cat-checklist input").each(function(){
	this.type="radio"
});

});
