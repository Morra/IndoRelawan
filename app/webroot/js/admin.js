//When click submit on edit page
// function editPage()
// {
    // window.onbeforeunload=function(){};
    // document.forms['PageEditForm'].submit();
// }

//not used
// function copy(text)
// {
    // if (window.clipboardData)
	// {
        // window.clipboardData.setData("Text",text);
    // }
// }

(function($){
	$(document).ready(function()
	{
	    //trigger for all form to show dialog box when user close windows but data didn't(forgot) save
	    $(document).delegate('form.notif-change','change',function()
		{	
	        window.onbeforeunload=function()
			{
	             return 'You have unsaved changes. Are you sure you want to leave this page?';    
	        };
	    });
	    
	    $(document).delegate('form' , 'submit' , function(){
	    	//alert('halow');
	    	window.onbeforeunload=function(){};
	    });
	    
	    // AJAX IN EDIT FORM (CHANGE LANGUAGE)
		$('div#child-content').on("click", '.ajax_myform', function(e){
			e.preventDefault();
			var myobj = $(this);
			var myid = 'ajaxed';
			var url = myobj.attr('href');
			
			if(url == "#")
			{
				// change now language
				var now_language = $(this).html().substr(0,2);
				$('a#lang_identifier').html( now_language );
				$('input[type=hidden]#myLanguage').val( now_language.toLowerCase() );
			}
			else
			{
				var spinner = '<div class="loading" style="height:'+$('#'+myid).height()+'px;"></div>';
				$.ajaxSetup({cache: false});
				$('div#'+myid).empty();
				$('div#'+myid).html(spinner).load(url,[],function(){
					history.pushState(null, '', url);
					// get hidden data
					var now_language = $('input[type=hidden]#now_language').val();
					var entry_id = $('input[type=hidden]#entry_id').val();
					var entry_status = $('input[type=hidden]#entry_status').val();
					var entry_title = $('input[type=hidden]#entry_title').val();
					var entry_image_id = $('input[type=hidden]#entry_image_id').val();
					var entry_image_type = $('input[type=hidden]#entry_image_type').val();
					// change now language
					$('a#lang_identifier').html( now_language );
					// change action for status or delete in form
					if($('div.action-in-form').length > 0)
					{
						if(url.indexOf('lang=') >= 0)
						{
							$('div.action-in-form').find('a.dropdown-toggle').attr('data-toggle','');
						}
						else
						{
							$('div.action-in-form').find('a.dropdown-toggle').attr('data-toggle','dropdown');
							if($('a.ajaxActivate').length > 0)
							{
								$('a.ajaxActivate').attr('href' , 'entries/change_status/'+entry_id );
								$('a.ajaxActivate').html('<i class="'+(entry_status==1?'icon-eye-close':'icon-eye-open')+'"></i> '+(entry_status==1?'Disable':'Active'));
							}
						}
					}
					// change form title
					$('h2#form-title-entry').html(url.indexOf('lang=') >= 0? 'TRANSLATE ('+entry_title+')' : entry_title);
					// refresh ckeditor...
					$.fn.refresh_ckeditor();
					// refresh cover image...
					$('img#mySelectCoverAlbum').attr('src',site+'img/upload/thumb/'+entry_image_id+'.'+entry_image_type);
					if(entry_image_id == 0)
					{	
						$('.select').html('Select Cover');
						$('.remove').hide();
					}
					else
					{
						$('.select').html('Change Cover');
						$('.remove').show();
					}
					// refresh colorbox image link !!
					$('.get-from-library').colorbox({close: '<div class="icon-remove icon-white"></div>'});
				});
			}
		});
	});
})(jQuery);