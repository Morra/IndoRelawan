var instance = '';
function lang_unslug(str)
{
	var temp = str.split('_');
	var result = temp[0].toUpperCase()+' - '+temp[1].substr(0,1).toUpperCase()+temp[1].substr(1);
	return result;
}
function show_confirm(message , url)
{
	var r=confirm(message);
	if (r==true)
	{
		window.location = site+url;
	}
}
function changeLocation(url)
{
	window.location = site+url;
}

function deleteChildPic(myobj)
{
	$(myobj).parents("div.photo").animate({opacity : 0 , width : 0, marginRight : 0},1000,function(){
		$(this).detach();
		var jumlah = parseInt($('strong#galleryCount').html());
		$('strong#galleryCount').html((jumlah - 1)+' PICTURES');
	});
}

(function($) {
	$.fn.refresh_ckeditor = function(){
		// call CK editor script...
		var instances = CKEDITOR.instances;
		for (var z in instances)
		{
			if(CKEDITOR.instances[z])
			{
				delete CKEDITOR.instances[z];
			}
		}
		$.fn.my_ckeditor();
	}

	$.fn.slug = function(src){
		var result = src.replace(/\s/g,'-').replace(/[^a-zA-Z0-9\-]/g,'-').toLowerCase();
		return result;
	}

	$.fn.editSlug = function(id){
		if($('a#edit_slug').html() == 'Edit Slug')
		{
			var tempText = $('p#slug_source').html();
			$('a#edit_slug').html('Save Slug');
			$('input[type=text]#slug_value').val(tempText.substring(tempText.lastIndexOf('/')+1));
			$('input[type=text]#slug_value').show();
			$('p#slug_source').html(tempText.substring(0 , tempText.lastIndexOf('/') + 1));
		}
		else
		{
			$.ajaxSetup({cache: false});
			$.post(site+'entries/update_slug',{
				id: id,
				slug: $('input[type=text]#slug_value').val()
			},function(slug){
				$('a#edit_slug').html('Edit Slug');
				$('input[type=text]#slug_value').hide();
				$('p#slug_source').html($('p#slug_source').html() + slug);
			});
		}
	}

	$.fn.removePicture = function(myImageId){
		// for remove cover image embedded in title area...
		if(myImageId == null)
		{
			$('img#mySelectCoverAlbum').attr('src' , site+'img/upload/thumb/0.jpg');
			$('input#mySelectCoverId').attr('value','0');
			$('.select').html('Select Cover').show();
			$('.remove').hide();
		}
		else // for remove cover book image...
		{
			$('img#myEditCoverImage_'+myImageId).attr('src' , site+'img/upload/thumb/0.jpg');
			$('input[type=hidden]#myEditCoverId_'+myImageId).attr('value' , '0');
		}
	}

	$.fn.updateChildPic = function(imgId , imgType , imgName){
		// for cover book image...
		if($('input#mycaller').val().indexOf('myEditCoverImage') == 0)
		{
			var temp = $('input#mycaller').val().split('_');
			var myImageId = temp[temp.length-1];

			$('img#myEditCoverImage_'+myImageId).attr('src',site+'img/upload/setting/'+imgId+'.'+imgType);
			$('input#myEditCoverId_'+myImageId).attr('value',imgId);
		}
		// for cover image embedded in title area...
		else if($('input#mycaller').val() == 'mySelectCoverAlbum')
		{
			$('img#mySelectCoverAlbum').attr('src',site+'img/upload/setting/'+imgId+'.'+imgType);
			$('input#mySelectCoverId').attr('value',imgId);

			var tes = $('.select').html();
			if (tes == 'Select Cover')
			{
				$('.select').html('Change Cover');
				$('.remove').show();
			}
		}
		// for album picture details
		else if($('input#mycaller').val() == 'myPictureWrapper')
		{
			$('div#myPictureWrapper').append('<div class="photo"><div class="image"><img style="width:150px" title="'+imgName+'" alt="'+imgName+'" src="'+site+'img/upload/thumb/'+imgId+'.'+imgType+'" /></div><div class="description"><p>'+imgName+'</p><a href="javascript:void(0)" onclick="deleteChildPic(this);" class="icon-remove icon-white"></a></div><input type="hidden" value="'+imgId+'" name="data[Entry][image][]" /></div>');
			var jumlah = parseInt($('strong#galleryCount').html());
			$('strong#galleryCount').html((jumlah + 1)+' PICTURES');
		}
		// for CK Editor
		else if($('input#mycaller').val() == 'ckeditor')
		{
			var mytext = '<img style="width:150px" title="'+imgName+'" alt="'+imgName+'" src="'+site+'img/upload/'+imgId+'.'+imgType+'" />';

			var oEditor = CKEDITOR.instances[window.instance];
			var newElement = CKEDITOR.dom.element.createFromHtml(mytext, oEditor.document);
			oEditor.insertElement(newElement);
		}

		$.colorbox.close();
		$("a#upload").removeClass("active");

		if($('input#mycaller').val() == 'refresh')
		{
			$.ajaxSetup({cache: false});
			$.post(site+$('input[type=hidden]#targetAjax').val(),{
				imgId: imgId,
				imgName: imgName,
				parentId: $('input[type=hidden]#parentId').val()
			},function(){
				window.location = site + $('input[type=hidden]#targetLocation').val() + '/' + $('input[type=hidden]#parentId').val();
			});
		}
	}

	$.fn.my_ckeditor = function (){
		$('.btn-radio').click(function(){
          $('.btn-radio').each(function(){
            $(this).removeClass('active');
          });

          $(this).addClass('active');
        });

        // callback ckeditor
        $('.ckeditor').ckeditor(function(e){

        			// if(CKEDITOR.instances[$(e).attr('name')])
        			// {
        				// delete CKEDITOR.instances[$(e).attr('name')];
        			// }

					setSize();

					// access popup media library from ckeditor
					$('form table.cke_editor .cke_button_image').attr('onclick','');
					$('form table.cke_editor .cke_button_image').click(function(){
						var test = $(this).parents('span[class^=cke_skin_]').attr('id');
						window.instance = test.substr(4);
						$.colorbox({ href: site+'entries/media_popup_single/1/ckeditor/'+$('input#myTypeSlug').val()});
					});

					var instances = CKEDITOR.instances;
					for (var z in instances) {
						CKEDITOR.instances[z].on('saveSnapshot', function(){
							window.onbeforeunload=function()
							{
					             return 'You have unsaved changes. Are you sure you want to leave this page?';
					        };
						});
					}
        },{
          toolbar : [
						{ name: 'document', items : [ 'Source','-','Save' ] },
						{ name: 'clipboard', items : [ 'PasteText','Undo','Redo' ] },
						{ name: 'styles', items : [ 'Format' ] },
						{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
						{ name: 'insert', items : [ 'Image','Table','HorizontalRule' ] },
						{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
						{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
					],
          width:"100%",
          filebrowserBrowseUrl : site+'js/ckfinder/ckfinder.html',
          filebrowserImageBrowseUrl : site+'js/ckfinder/ckfinder.html?Type=Images',
          filebrowserFlashBrowseUrl : site+'js/ckfinder/ckfinder.html?Type=Flash',
          filebrowserUploadUrl : site+'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
          filebrowserImageUploadUrl : site+'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
          filebrowserFlashUploadUrl : site+'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
	}

	$.fn.copyToClipboard = function(myobj,myid , mytext)
	{
		var clip = new ZeroClipboard.Client();
	    clip.setText( mytext );

	    clip.addEventListener( 'mouseOver', function(client) {
            $(myobj).parent('div.description').fadeIn('fast');
        } );

        // clip.addEventListener( 'mouseOut', function(client) {
            // console.log("mouse out");
        // } );

	    clip.addEventListener( 'complete', function(client, text) {
            alert("Image tag has been copied into clipboard !");
			$(myobj).parent('div.description').fadeOut('fast');
        } );
        clip.glue(myid);
	}

	$.fn.del_param_lang = function(src){
		var temp = src.indexOf('lang=');
		if(temp == -1)
		{
			return src;
		}
		else if(src.substr(temp+7,1) == '&')
		{
			return src.substring(0,temp) + src.substr(temp+8);
		}
		else
		{
			return src.substring(0,temp-1);
		}
	}

	$.fn.ajax_mylink = function (myobj , myid , heightspin , setpaging , altforurl){
		var url = myobj.attr(altforurl==null?'href':'alt');
		var spinner;
		if(heightspin == null){
			spinner = '<div class="loading" style="height:'+$('#'+myid).height()+'px;"></div>';
		}else{
			spinner = '<div class="loading" style="height:'+heightspin+'px;"></div>';
		}

		$.ajaxSetup({cache: false});
		$('div#'+myid).empty();
		$('div#'+myid).html(spinner).load(url, {
			search_by : (myobj.hasClass('searchMeLink')?($('input#searchMe').val().length==0?' ':$('input#searchMe').val()):''),
			order_by : ( myobj.attr('alt') != null &&  myobj.attr('alt').length>0 && altforurl==null ? myobj.attr('alt'):'')
		}, function(){
			if(setpaging != 'media')
			{
				history.pushState(null, '', url);
			}
			// update pagination...
			var address = url.substring(0 , url.lastIndexOf('/'));
			var paging;
			var url_params = '';
			if(url.indexOf('?') >= 0)
			{
				paging = url.substring(url.lastIndexOf('/') + 1 , url.indexOf('?'));
				url_params = $.fn.del_param_lang(url.substring(url.indexOf('?')));
			}
			else
			{
				paging = url.substring(url.lastIndexOf('/') + 1);
			}

			$.fn.update_paging(address , paging , url_params);
			if(myobj.attr('alt')!=null && altforurl==null)
			{
				//$('a.order_by').parents('div.btn-group').find('a.btn:first').html('<i class="icon-cog"></i>&nbsp;'+string_unslug(myobj.attr('alt')));
				$('a.order_by').each(function(){
					$(this).html(string_unslug($(this).attr('alt')));
				});
				myobj.html(string_unslug(myobj.attr('alt'))+' <i class="icon-ok"></i>');
			}
			else if(myobj.hasClass("langLink"))
			{
				var p = url.indexOf('lang=');
				$("a#lang_identifier").html(url.substr(p+5,2).toUpperCase());
			}
		});
	};

	$.fn.update_paging = function (address , paging , url_params)
	{
		paging = parseInt(paging);
		var left_limit = parseInt($('input#myLeftLimit').val());
		var right_limit = parseInt($('input#myRightLimit').val());
		var myCountPage = parseInt($('input#myCountPage').val());

		// set Prev Paging
		if(paging <= 1)
		{
			$('li#myPagingFirst').attr("class" , "disabled");
			$('li#myPagingPrev').attr("class" , "disabled");
		}
		else
		{
			$('li#myPagingFirst').attr("class" , "");
			$('li#myPagingPrev').attr("class" , "");
		}
		$('li#myPagingPrev a').attr("href" , address+"/"+(paging-1)+url_params);

		// set Next Paging
		if(paging >= myCountPage)
		{
			$('li#myPagingLast').attr("class" , "disabled");
			$('li#myPagingNext').attr("class" , "disabled");
		}
		else
		{
			$('li#myPagingLast').attr("class" , "");
			$('li#myPagingNext').attr("class" , "");
		}
		$('li#myPagingNext a').attr("href" , address+"/"+(paging+1)+url_params);

		// set Page Numbering
		$('div.pagination ul li').removeClass("active");
		for(i=left_limit , index=1 ; i <= right_limit ; ++i , ++index)
		{
			$('li#myPagingNum'+index+" a").html(i);
			$('li#myPagingNum'+index+" a").attr("href" , address+"/"+i+url_params);
			if(i == paging)
			{
				$('li#myPagingNum'+index).addClass('active');
			}
		}

		// UPDATE ORDER BY LINK !!
		$('a.order_by').attr("href" , address+"/"+paging+url_params);
	}

	$.fn.update_paging_attr = function (controller , action , paging , lang)
	{
		paging = parseInt(paging);
		if(lang == null)
		{
			lang = "";
		}
		else
		{
			lang = "/" + lang;
		}

		// set Prev Paging
		if(paging <= 1)
		{
			$('li#myPagingPrev').attr("class" , "disabled");
		}
		else
		{
			$('li#myPagingPrev').attr("class" , "");
		}
		$('li#myPagingPrev a').attr("href" , site+controller+"/"+action+"/"+(paging-1)+lang);

		// set Next Paging
		var myCountPage = $('input#myCountPage').val();
		if(paging >= myCountPage)
		{
			$('li#myPagingNext').attr("class" , "disabled");
		}
		else
		{
			$('li#myPagingNext').attr("class" , "");
		}
		$('li#myPagingNext a').attr("href" , site+controller+"/"+action+"/"+(paging+1)+lang);

		// set Page Numbering
		$('div.pagination ul li').removeClass("active");
		$('div.pagination ul li#myPagingNum'+paging).addClass("active");
		for(i=1 ; i <= myCountPage ; ++i)
		{
			$('li#myPagingNum'+i+" a").attr("href" , site+controller+"/"+action+"/"+i+lang);
		}
	}

	$(function() {
		// $('div#child-content').on("click", '.ajax_mylink', function(e){
			// e.preventDefault();
			// var heightSpin = null;
			// if($('form#myFormList').height())
			// {
				// heightSpin = $('form#myFormList').height();
			// }
//
			// if(!($(this).parent("li").hasClass("disabled") || $(this).parent("li").hasClass("active")))
			// {
				// $.fn.ajax_mylink($(this),"ajaxed" , heightSpin);
			// }
		// });
//
		// $('div#child-content').on("click", '.ajax_mytable', function(e){
			// e.preventDefault();
			// if(!($(this).parent("li").hasClass("disabled") || $(this).parent("li").hasClass("active")))
			// {
				// $.fn.ajax_mylink($(this),"ajaxed" , $('table#myTableList').height() , "table");
			// }
		// });

		$('div#child-content').on("click", 'a#myDeleteMedia', function(e){
			e.preventDefault();
			$.ajaxSetup({cache: false});
			var url = $(this).attr('href');
			var tempURL = url.split("/");

			$.get(url,function(result){
				if(result.length > 0)
				{
					var header = 'The following image is currently associated with the following database(s) :\n\n';
					var footer = '\nPlease remove them first !';
					alert(header + result + footer);
				}
				else
				{
					if(confirm("Are you sure want to delete this image?"))
					{
					  	window.location = site+"entries/deleteMedia/"+tempURL[tempURL.length - 1];
					}
				}
            });
		});

		// call CK editor script...
		if($('textarea.ckeditor').length > 0)
		{
			$.fn.my_ckeditor();
		}

		// disable link for LAST breadcrumb
		$('div.breadcrumbs p > a:last').attr('href' , 'javascript:void(0)');
		$('div.breadcrumbs p > a:last').css('text-decoration' , 'none');
		$('div.breadcrumbs p > a:last').css('cursor' , 'default');

		// NEW MORRA CMS...
		$('div#child-content').on("click", '.ajax_mypage', function(e){
			e.preventDefault();
			if(!($(this).parent("li").hasClass("disabled") || $(this).parent("li").hasClass("active")))
			{
				$.fn.ajax_mylink($(this),($(this).hasClass('searchMeLink')||$(this).hasClass('langLink')?"inner-content":"ajaxed"));
			}
		});

		// DELETE INPUT LIST IN EDIT TYPE MODEL ...
		$('tbody#myInputWrapper a.delete-field').live("click", function(){
			var r=confirm('Deleting this field will delete all values related, on all entries. Are you sure?');
			if (r==true)
			{
				$(this).parents("tr.input_list").animate({opacity : 0 , height : 0, marginBottom : 0},1000,function(){
					$(this).detach();
				});
			}
		});

		// CHANGE STATUS THROUGH AJAX IN EDIT FORM !!
		$('a.ajaxActivate').click(function(e){
			e.preventDefault();
			var myobj = $(this);
			if(myobj.html() == '<i class="icon-eye-close"></i> Disable')
			{
				var r=confirm('Are you sure want to disable this entry ?');
				if (r != true)
				{
					return;
				}
			}

			$.ajaxSetup({cache: false});
			$.get(site+$(this).attr('href'),function(result){
				$('div#cmsAlert').detach();
				var myAlert = '';
				var myMessage = '';
				if(result == 1)
				{
					myobj.html('<i class="icon-eye-close"></i> Disable');
					myAlert = 'success';
					myMessage = 'This entry has been activated.';

				}
				else
				{
					myobj.html('<i class="icon-eye-open"></i> Active');
					myAlert = 'error';
					myMessage = 'This entry has been disabled.';
				}

				var content = '<div id="cmsAlert" class="alert alert-'+myAlert+' full fl">';
				content += '<a class="close" data-dismiss="alert" href="#">&times;</a>';
				content += myMessage;
				content += '</div>';
				$('div#child-content').prepend(content);
			});
		});
// ------------------------------------------------------------------------------------------------------------------------------------ //
// ---------------------------------------------------- SETTINGS MASTER --------------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------ //
		// DELETE SETTINGS !!
		$('a.del_setting').live('click',function(){
			$.ajaxSetup({cache: false});
			var myobj = $(this);
			if (confirm('Are you sure want to delete this info ?'))
			{
				$.get(site+'settings/delete/'+$(this).attr('alt'),function(){
					myobj.parents("div.control-group").animate({opacity : 0 , height : 0, marginBottom : 0},1000,function(){
						$(this).detach();
						if($('a.del_setting').length == 0)
						{
							// DELETE ADD SETTINGS WARNING !!
							$('div#additional_info > div').addClass('well');
							$('div#additional_info').find('p').html('Voluptate rem dignissimos, vulputate nesciunt eget fermentum sunt vitae, duis nobis eligendi vitae sint dolore labore ab excepteur commodi a cras eos odio placerat, voluptatem aliquet elementum! Augue explicabo? Anim! Odit quos!');
							$('a.add_setting').css('margin-left' , '-150px');
						}
					});
				});
			}
		});

		// ADD SETTINGS !!
		$('a.add_setting').click(function(){
			if($(this).next('a.cancel_setting').css('display') == 'none')
			{
				$(this).prev('input[type=text]').show();
				$(this).prev('input[type=text]').val('');
				$(this).html('Save');
				$(this).next('a.cancel_setting').show();
				$(this).parent('div.controls').prev('label.control-label').html('New Key');

				// DELETE ADD SETTINGS WARNING !!
				$('div#additional_info > div').removeClass('well');
				$('div#additional_info').find('p').html('');
				$(this).css('margin-left' , '0px');
			}
			else
			{
				var key = $.trim($(this).prev('input[type=text]').val());
				if(key.length <= 0 || !isNaN(key))
				{
					alert('Invalid Key! Please try again..');
					return;
				}

				var myobj = $(this);
				$.ajaxSetup({cache: false});
				$.post(site+'settings/add',{
					key: key
				},function(data){
					data.counter = parseInt(data.counter);
					var contents = '<div class="control-group">';
					contents += '<label class="control-label">'+data.slug_key+'</label>';
					contents += '<div class="controls">';
					contents += '<input class="input-xlarge" type="text" size="200" value="" name="data[Setting]['+data.counter+'][value]"/>';
					contents += '&nbsp;<a alt="'+(data.counter+1)+'" href="javascript:void(0)" class="btn del_setting">Remove</a>';
					contents += '</div>';
					contents += '</div>';
					$('div#inputWrapper').append(contents);

					myobj.html('Add More Settings...');
					myobj.prev('input[type=text]').hide();
					myobj.next('a.cancel_setting').hide();
					myobj.parent('div.controls').prev('label.control-label').html('');
				},'json');
			}
		});

		// CANCEL SETTINGS !!
		$('a.cancel_setting').click(function(){
			var myobj = $(this).prev('a.add_setting');

			myobj.html('Add More Settings');
			myobj.prev('input[type=text]').hide();
			myobj.next('a.cancel_setting').hide();
			$(this).parent('div.controls').prev('label.control-label').html('');

			if($('a.del_setting').length == 0)
			{
				// DELETE ADD SETTINGS WARNING !!
				$('div#additional_info > div').addClass('well');
				$('div#additional_info').find('p').html('Voluptate rem dignissimos, vulputate nesciunt eget fermentum sunt vitae, duis nobis eligendi vitae sint dolore labore ab excepteur commodi a cras eos odio placerat, voluptatem aliquet elementum! Augue explicabo? Anim! Odit quos!');
				$(myobj).css('margin-left' , '-150px');
			}
		});
// ------------------------------------------------------------------------------------------------------------------------------------ //
// ---------------------------------------------------- END OF SETTINGS MASTER -------------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------------------------------ //
	});
})(jQuery);