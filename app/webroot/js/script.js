morra_autocomplete = new function(config){
	DEFAULT = {
		url: false, // required for ajax
		data: [], // required for data on local
		target_id: 'morra_autocomplete', // required
		onAdd: function(){ // on add callback
			
		},
		onResult: function(){ // on get results callback
		
		},
		onLoad: function(){ // on load callback
		
		},
		onComplete: function(){ // on complete callback
			
		},
		must_same: false,
		min_char: 3, // min search char
		// if you want additional helper
		// type = "select" -> for render select box
		// type = "input" -> for render input box
		helper: false,
		prepopulate: false
	};
	
	// Keys "enum"
	var KEY = {
			BACKSPACE: 8,
			TAB: 9,
			ENTER: 13,
			ESCAPE: 27,
			SPACE: 32,
			PAGE_UP: 33,
			PAGE_DOWN: 34,
			END: 35,
			HOME: 36,
			LEFT: 37,
			UP: 38,
			RIGHT: 39,
			DOWN: 40,
			NUMPAD_ENTER: 108,
			COMMA: 188
	};
	
	var options = $.extend(DEFAULT, config);
	
	var pos = '';
	var flag = false;
	var contain_id = 0;
	var results_list = false;
	var select = false;
	var click_on_list = false;
	
	$('.morra_autocomplete').parents('td').css('position', 'relative').css('');
	
	// RENDER AUTOCOMPLETE CONTAINER
	if($('.morra_autocomplete_suggestions').length == 0){
		$('body').append('<div class="morra_autocomplete_suggestions" style="position: absolute;"><ul></ul></div>');
		$('.morra_autocomplete').after('<input type="hidden" id="morra_autocomplete_'+options.target_id+'" />');
	}
	
	// hack for disabling browser autocomplete
	$('#'+options.target_id).attr('autocomplete', 'off');
	
	// render autocomplete label
	$('.morra_autocomplete').after('<div class="autocomplete-label"><i class="icon-plus"></i><p>Add Item</p></div>');
	$('.morra_autocomplete_suggestions').hide();
	
	// render autocomplete helper
	if(options.helper){
		$('body').append('<div class="morra_autocomplete_helper" style="display: none;"></div>');
		$('.morra_autocomplete_helper').append('<button class="btn btn-positive mac-helper-btn btn-small">Save</button><a href="javascript:void(0)" class="mac-helper-close" style="margin-left: 5px; color: #A1A1A1; display: inline-block;">&times;</a>');
		
		var len = options.helper.element.length;
		for(a=0;a<len;a++){
			// render select box element
			if(options.helper.element[a].info.element_type == 'select'){
				$('.mac-helper-btn').before('<select data-attr="'+options.helper.element[a].info.element_type+'" id="'+options.helper.element[a].info.element_id+'" name="'+options.helper.element[a].info.element_name+'" class="'+options.helper.element[a].info.element_class+'"></select>');
				
				var len2 = options.helper.element[a].data.length;
				for(b=0;b<len2;b++){
					$('#'+options.helper.element[a].info.element_id).append('<option value="'+options.helper.element[a].data[b].id+'">'+options.helper.element[a].data[b].name+'</option>');
				}
			}
			// render input box element
			else if(options.helper.element[a].info.element_type == 'input'){
				$('.mac-helper-btn').before('<input data-attr="'+options.helper.element[a].info.element_type+'" type="text" id="'+options.helper.element[a].info.element_id+'" name="'+options.helper.element[a].info.element_name+'" value="'+options.helper.element[a].data[0].value+'" />');
			}
		}
		
	}
	
	if(options.prepopulate){
		prepopulate_data();
		options.onComplete();
	}
	
	function prepopulate_data(){
		var data_len = options.prepopulate.length;
		for(var x = 0;x<data_len;x++){
		
			// give div element to all row for animation effect
			$('#'+options.target_id).parents('tr').find('td').each(function(){
				if($(this).find('>div').length == 0){
					var child_clone = $(this).html();
					$(this).html('<div>'+child_clone+'</div>');
				}
			});
		
			// init
			var clone = $('#'+options.target_id).parents('tr').clone();
			clone.find('.morra_autocomplete').remove();
			clone.find('.autocomplete-label').remove();
			clone.find('input[type="text"]').removeAttr('disabled');
			
			var el_str = "";
			var el_helper = '';
			
			if(options.helper){
				el_helper = '<a href="javascript:void(0);" data-id="'+now+'" class="mac-detail"><i class="icon-list-alt"></i></a>';
			}
			
			// element container
			var table_parent = $('#'+options.target_id).parents('table');
			table_parent.find('tbody tr:nth-last-child(1)').before(clone);
			
			var general_len = options.helper.element.length;
			var general_str = '';
			for(var n = 0;n < general_len; n++){
				general_str = general_str + '<input type="hidden" name="helper_element_id_'+(n+1)+'['+now+']" value="'+options.prepopulate[x].element[n].id+'" />';
				general_str = general_str + '<input type="hidden" name="helper_element_name_'+(n+1)+'['+now+']" value="'+options.prepopulate[x].element[n].name+'" />';
				general_str = general_str + '<a class="mac-detail" data-id="'+now+'" name="helper_element_label_'+(n+1)+'['+now+']" href="javascript:void(0);">'+ options.prepopulate[x].element[n].name +'</a>';
				
				if(n != general_len-1){
					general_str = general_str + " - ";
				}
			}
			
			var element_now = table_parent.find('tbody tr:nth-last-child(2) td:nth-child(1)').prepend('<div class="mac-description"><h4>'+options.prepopulate[x].main.name+'</h4><div class="general">'+general_str+'</div><div class="mac-actions">'+el_helper+'<a href="javascript:void(0);" class="mac-close">&times;</a></div></div>');
			
			table_parent.find('tbody tr:nth-last-child(2) td:nth-child(1) .mac-description').append('<input type="hidden" name="autocomplete_id['+now+']" value="'+options.prepopulate[x].main.id+'" />');
			contain_id = 0;
			table_parent.find('tbody tr:nth-last-child(2) td:nth-child(1) .mac-description').append('<input type="hidden" name="autocomplete_name['+now+']" value="'+options.prepopulate[x].main.name+'" />');
			now++;
			element_now.parent().find('input').eq(1).trigger('focus');
			
			// animate new row					
			table_parent.find('tbody tr:nth-last-child(2) td div').css('display', 'none');
			table_parent.find('tbody tr:nth-last-child(2) td div').slideDown('fast');
//				global = table_parent.find('tbody tr:nth-last-child(2) td div');
			
			// reset autocomplete input box
			$('#'+options.target_id).val('');
			$('#'+options.target_id).siblings('.autocomplete-label').show();
			hide_suggestions('all');
			
			// attach event && detach
			$('.mac-close').unbind('click');
			$('.mac-close').click(function(){
				$('#'+options.target_id).show();
				
				$(this).parents('tr').find('td > div').slideUp('fast').promise().done(function(){
					$(this).parents('tr').remove();
				});
			});
			
			$('.mac-detail').unbind('click');
			$('.mac-detail').click(function(){
				// get current position
				pos = $(this).parents('td').offset();
				$('.morra_autocomplete_helper').css('top', ($(this).parents('td').outerHeight() + pos.top + 3)+'px');
				$('.morra_autocomplete_helper').css('left', pos.left+'px');
				
				$('.morra_autocomplete_helper').slideDown('fast');
				$('.morra_autocomplete_helper').attr('data-id', $(this).attr('data-id'));
			});
			
			$('.mac-helper-close').unbind('click');
			$('.mac-helper-close').click(function(){
				// close the helper
				$('.morra_autocomplete_helper').slideUp('fast');
			});
			
			$('.mac-helper-btn').unbind('click');
			$('.mac-helper-btn').click(function(){
				var siblings = $(this).siblings('*');
				var parent = $(this).parent().attr('data-id');
				var len_element = options.helper.element.length;
				for(var a =0;a<len_element;a++){
					var el = $(siblings[a]);
					$('[name="helper_element_id_'+(a+1)+'['+parent+']"]').val(el.val());
					
					if(el.attr('data-attr') == 'select'){
						$('[name="helper_element_name_'+(a+1)+'['+parent+']"]').val(el.find('option:selected').text());
						$('[name="helper_element_label_'+(a+1)+'['+parent+']"]').text(el.find('option:selected').text());
					}else if(el.attr('data-attr') == 'input'){
						$('[name="helper_element_name_'+(a+1)+'['+parent+']"]').val(el.text());
						$('[name="helper_element_label_'+(a+1)+'['+parent+']"]').text(el.text());
					}
				}
				
				$('.mac-helper-close').trigger('click');
			});
			
			// callback on add item
			options.onAdd();
		}
	}
	
	function search(query){
		var len = query.length;
	
		// if char is not sufficient
		if(len >= options.min_char){
		
			if($('.morra_autocomplete_suggestions ul').length == 0){
				$('.morra_autocomplete_suggestions').append('<ul></ul>');
			}
	
			if(options.url){
				// if get data from ajax
				// NOTES: data must be in json e.g. {id: 1, name: 'test'}
				$.ajax({
					url: options.url+'?q='+query,
					success: function(data){
						data = jQuery.parseJSON(data);
						global = data;
						if(data){
							$(data).each(function(){
								var tmp_data = this.name.toLowerCase();
								
								// bold current word
								if(tmp_data.indexOf(query) != -1){
									var regex = new RegExp(query, "ig");
									var str = this.name.replace(regex, '<b>'+query+'</b>');
									$('.morra_autocomplete_suggestions ul').append('<li data-id="'+this.id+'" data-attr="'+this.name+'">'+str+'</li>');
									is_data = true;
								}
							});
							results_list = true;
							
							// if there's no data
							if(!is_data){
								results_list = false;
								no_suggestions();
							}
						}else{
							results_list = false;
							no_suggestions();
						}
						
						// callback on result
						options.onResult();
					}
				});
			}else{
				// get from local data
				var len = options.data.length;
				var is_data = false;
				
				for(var a=0;a < len;a++){
					var data = options.data[a];
					var tmp_data = data.name.toLowerCase();
					
					// search the relevant chars
					if(tmp_data.indexOf(query) != -1){
						var regex = new RegExp(query, "ig");
						var str = data.name.replace(regex, '<b>'+query+'</b>');
						$('.morra_autocomplete_suggestions ul').append('<li data-id="'+data.id+'" data-attr="'+data.name+'">'+str+'</li>');
						is_data = true;
					}
				}
				results_list = true;
				
				// if there's no data
				if(!is_data){
					results_list = false;
					no_suggestions();
				}
				
				// callback on result
				options.onResult();
			}
		}else{
			hide_suggestions('all');
		}
	}

	function select_item(element){
		// get ID
		var id = element.attr('data-id');
		contain_id = id;
		// $('#morra_autocomplete_'+options.target_id).val(id);
		$('#'+options.target_id).val(element.attr('data-attr'));
		hide_suggestions('all');
		create_element();
		
		// callback on add item
//			options.onAdd();
	}
	
	function no_suggestions(){
		if($('.morra_autocomplete_suggestions p').length > 0){
			$('.morra_autocomplete_suggestions p').html('No suggestion found')
		}else{
			$('.morra_autocomplete_suggestions').prepend('<p>No suggestion found</p>');
		}
		flag = true;
	}
	
	function reload_suggestions(){
		results_list = false;
		$('.morra_autocomplete_suggestions').show().empty();
	}
	
	function show_suggestions(){
		$('.morra_autocomplete_suggestions').show();
		$('.morra_autocomplete_suggestions').css('opacity', '1');
	}
	
	function hide_suggestions(selection){
		$('.morra_autocomplete_suggestions').css('opacity', '0');
		if(selection == 'all'){
			$('.morra_autocomplete_suggestions').hide();
		}
	}
	
	function create_element(){
		// check for minimal characters && must be same conditions
		var len = $('#'+options.target_id).val().length;
		var condition = false;
		
		if(len >= options.min_char){
			condition = true;
			if(options.must_same && results_list != true){
				condition = false;
				$('#'+options.target_id).val('');
				$('#'+options.target_id).siblings('.autocomplete-label').show();
			}
		}
		
		// jika kondisinya harus sama
		if(options.must_same && results_list != true){
			condition = false;
		}
		
		// when all requirements are met
		if(condition == true){
			if($('#'+options.target_id).val() != ''){
				// give div element to all row for animation effect
				$('#'+options.target_id).parents('tr').find('td').each(function(){
					if($(this).find('>div').length == 0){
						var child_clone = $(this).html();
						$(this).html('<div>'+child_clone+'</div>');
					}
				});
			
				// init
				var clone = $('#'+options.target_id).parents('tr').clone();
				clone.find('.morra_autocomplete').remove();
				clone.find('.autocomplete-label').remove();
				clone.find('input[type="text"]').removeAttr('disabled');
				
				var el_str = "";
				var el_helper = '';
				
				if(options.helper){
					el_helper = '<a href="javascript:void(0);" data-id="'+now+'" class="mac-detail"><i class="icon-list-alt"></i></a>';
				}
				
				// element container
				var table_parent = $('#'+options.target_id).parents('table');
				table_parent.find('tbody tr:nth-last-child(1)').before(clone);
				
				var general_len = options.helper.element.length;
				var general_str = '';
				for(var n = 0;n < general_len; n++){
					general_str = general_str + '<input type="hidden" name="helper_element_id_'+(n+1)+'['+now+']" />';
					general_str = general_str + '<input type="hidden" name="helper_element_name_'+(n+1)+'['+now+']" />';
					general_str = general_str + '<a class="mac-detail" data-id="'+now+'" name="helper_element_label_'+(n+1)+'['+now+']" href="javascript:void(0);">'+ options.helper.element[n].info.element_label +'</a>';
					
					if(n != general_len-1){
						general_str = general_str + " - ";
					}
				}
				
				var element_now = table_parent.find('tbody tr:nth-last-child(2) td:nth-child(1)').prepend('<div class="mac-description"><h4>'+$('#'+options.target_id).val()+'</h4><div class="general">'+general_str+'</div><div class="mac-actions">'+el_helper+'<a href="javascript:void(0);" class="mac-close">&times;</a></div></div>');
				
				table_parent.find('tbody tr:nth-last-child(2) td:nth-child(1) .mac-description').append('<input type="hidden" name="autocomplete_id['+now+']" value="'+contain_id+'" />');
				contain_id = 0;
				table_parent.find('tbody tr:nth-last-child(2) td:nth-child(1) .mac-description').append('<input type="hidden" name="autocomplete_name['+now+']" value="'+$('#'+options.target_id).val()+'" />');
				now++;
				element_now.parent().find('input').eq(1).trigger('focus');
				
				// animate new row					
				table_parent.find('tbody tr:nth-last-child(2) td div').css('display', 'none');
				table_parent.find('tbody tr:nth-last-child(2) td div').slideDown('fast');
//					global = table_parent.find('tbody tr:nth-last-child(2) td div');
				
				// reset autocomplete input box
				$('#'+options.target_id).val('');
				$('#'+options.target_id).siblings('.autocomplete-label').show();
				hide_suggestions('all');
				
				// attach event && detach
				$('.mac-close').unbind('click');
				$('.mac-close').click(function(){
					$('#'+options.target_id).show();
					
					$(this).parents('tr').find('td > div').slideUp('fast').promise().done(function(){
						$(this).parents('tr').remove();
					});
				});
				
				$('.mac-detail').unbind('click');
				$('.mac-detail').click(function(){
					// get current position
					pos = $(this).parents('td').offset();
					$('.morra_autocomplete_helper').css('top', ($(this).parents('td').outerHeight() + pos.top + 3)+'px');
					$('.morra_autocomplete_helper').css('left', pos.left+'px');
					
					$('.morra_autocomplete_helper').slideDown('fast');
					$('.morra_autocomplete_helper').attr('data-id', $(this).attr('data-id'));
				});
				
				$('.mac-helper-close').unbind('click');
				$('.mac-helper-close').click(function(){
					// close the helper
					$('.morra_autocomplete_helper').slideUp('fast');
				});
				
				$('.mac-helper-btn').unbind('click');
				$('.mac-helper-btn').click(function(){
					var siblings = $(this).siblings('*');
					var parent = $(this).parent().attr('data-id');
					var len_element = options.helper.element.length;
					for(var a =0;a<len_element;a++){
						var el = $(siblings[a]);
						$('[name="helper_element_id_'+(a+1)+'['+parent+']"]').val(el.val());
						
						if(el.attr('data-attr') == 'select'){
							$('[name="helper_element_name_'+(a+1)+'['+parent+']"]').val(el.find('option:selected').text());
							$('[name="helper_element_label_'+(a+1)+'['+parent+']"]').text(el.find('option:selected').text());
						}else if(el.attr('data-attr') == 'input'){
							$('[name="helper_element_name_'+(a+1)+'['+parent+']"]').val(el.text());
							$('[name="helper_element_label_'+(a+1)+'['+parent+']"]').text(el.text());
						}
					}
					
					$('.mac-helper-close').trigger('click');
				});
			}
			
			// callback on add item
			options.onAdd();
		}else{
			$('#'+options.target_id).val('');
			$('#'+options.target_id).siblings('.autocomplete-label').show();
		}
	}
	
	// on keyup event
	$('#'+options.target_id).keyup(function(e){
		e.preventDefault();
		var query = $(this).val();
		
		switch(e.keyCode) {
			case KEY.UP:
				var get_active = $('.morra_autocomplete_suggestions ul li.active').index();
				$('.morra_autocomplete_suggestions ul li').removeClass('active');
				$('.morra_autocomplete_suggestions ul li').eq(get_active-1).addClass('active');
				break;
			case KEY.DOWN:
				var get_active = $('.morra_autocomplete_suggestions ul li.active').index();
				$('.morra_autocomplete_suggestions ul li').removeClass('active');
				$('.morra_autocomplete_suggestions ul li').eq(get_active+1).addClass('active');
				break;
			case KEY.LEFT:
			case KEY.RIGHT:
				break;
			case KEY.ENTER:
				var get_active = $('.morra_autocomplete_suggestions ul li.active');
				select_item($(get_active));
				break;
			default:
				show_suggestions();
				reload_suggestions();
				search(query);
				break;
		}
	});
	
	// on label click
	$('.autocomplete-label').click(function(){
		$(this).siblings('.morra_autocomplete').trigger('focus');
	});
	
	// on focus
	$('#'+options.target_id).focus(function(){
		$(this).addClass('morra_autocomplete_focus');
		$(this).siblings('.autocomplete-label').hide();
		// show_suggestions();
		hide_suggestions('all');
		
		$(this).parents('form').keydown(function(f){
			switch(f.keyCode) {
				case KEY.ENTER:
					f.preventDefault();
					return false;
					break;
			}
		});
		
		// reposition suggestions list
		pos = $(this).offset();
		$('.morra_autocomplete_suggestions').css('left', pos.left+'px');
		$('.morra_autocomplete_suggestions').css('top', (pos.top+$(this).outerHeight()+3)+'px');
		$('.morra_autocomplete_suggestions').css('width', ($(this).outerWidth())+'px');
	});
	
	// on suggestion click event
	$('body').on('mouseover', '.morra_autocomplete_suggestions', function(){
		click_on_list = true;
	});
	
	$('body').on('mouseout', '.morra_autocomplete_suggestions', function(){
		click_on_list = false;
	});
	
	$('body').on('click', '.morra_autocomplete_suggestions ul li', function(e){
		select_item($(this));
		// hide_suggestions('all');
	});
	
	// on blur
	$('#'+options.target_id).blur(function(){
		if($(this).val() == ''){
			$(this).siblings('.autocomplete-label').show();
		}
		hide_suggestions();
		
		// if must be same
		if(options.must_same == true){
			if($(this).val() == $('.morra_autocomplete_suggestions ul li.active').attr('data-attr')){
				create_element();
			}else{
				$('#'+options.target_id).val('');
				$('#'+options.target_id).siblings('.autocomplete-label').show();
			}
		}else{
			if(click_on_list == false){
				create_element();
			}
		}
	});
}

function bootstrap_hack(){
	// badge on click
	$('table .badge').bind('click', function(){
		window.location = $(this).find('a').attr('href');
	});
}

function init_sortable(){
	$('table.sortable tbody').sortable({ opacity: 0.6, cursor: 'move',
		stop: function(event, ui) {
			var tmp = '';
			// construct
			$('table.sortable tbody tr').each(function(){
				tmp += $(this).attr('alt') + ',';
			});
							
			$.ajaxSetup({cache: false});
			$.post(site+'entries/reorder_list',{
				src_order: $('input[type=hidden]#determine').val(),
				dst_order: tmp
			});
		}
	});;
}

function init_popup(){
	$('.popup.url').colorbox();
	$('.popup.inline-url').colorbox();
}

function relayout(){
	// menghitung ulang semua elemen yang ada padding agar rapi
	// untuk yang input-full
	$('.input-full').each(function(){
		var w = $(this).width();
		var ow = $(this).outerWidth();
		var p = ow-w;
		$(this).css('width', (w-p)+'px');
	});
	
	// untuk yang ada input-append
	// khusus order
	$('.order .change .input-append, .order .change .input-prepend, .order2 .tabs .input-prepend').each(function(){
		var addon_w = $(this).find('.add-on').outerWidth();
		var input_w = $(this).find('input').width();
		$(this).find('input').css('width', (input_w-addon_w)+'px');
	});
}

function setSize(){
	// sidebar
	var p_left = $('.content').css('padding-left');
	var m_left = $('.content').css('margin-left');
	
	if(m_left > '0px'){
		// $('.content').css('padding-left', $('.content').css('margin-left'));
		// $('.content').css('margin-left', '0px');
	}
	
	var c_owidth = $('.content').outerWidth(true);
	var c_width = $('.content').width();
	var c_height = $('.content').height();
	var l_width = $('.layout-body').width();
	var s_width = $('.sidebar').width();
	var s_height = $('.sidebar').height();
	
	// console.log((l_width-s_width));
	// $('.content').css('width', (l_width-s_width)-1+'px');
	
	if(c_height < s_height){
		$('.content').css('height', s_height+50+'px');
	}
}

$(document).ready(function(){
	// create extra line for header
	// $('.layout-header:nth-child(2)').append('<div class="extra-line"></div>')
	
	// destroy rubbish line
	// $('.coordinate .extra-line').remove();

	var imgReady = $('body').imagesLoaded();
	imgReady.always(function(){
		setSize();
		
		// extra line position
		// var sidebar_width = $('.sidebar').width();
		// $('.extra-line').css('left', (sidebar_width-2)+'px');
	});
	
	$('div#child-content').on("click", '#child-menu .btn-group .btn', function(){	
		$('#child-menu .btn').removeClass('active');
		$(this).addClass('active');
	});
	
	// list button hover
	$('div#child-content').on("mouseenter", 'table tr', function(){	
		$(this).find('td .btn').css('display', 'inline');
	});
	
	$('div#child-content').on("mouseleave", 'table tr', function(){	
		$(this).find('td .btn').css('display', 'none');
	});
	
	// init sortable function
	init_sortable();
	
	// init popup function
	init_popup();
	
	// init date picker function
	$('input.dpicker').datepicker();
	// init bootstrap hack
	bootstrap_hack();
	// // copy tags function
	// $('div#child-content').on('click', '.copy-tag', function(e){
		// e.preventDefault();
		// // $.fn.copyToClipboard($(this).parents('div.photo').next('input[type=button]').attr('id') , 'wakakakak');
		// $(this).parents('div.photo').next('input[type=button]').click();
	// });
});

$(document).ready(function(){
	relayout();
});

// on resize
$(window).resize(function(){
	// setSize();
  // relayout();
	
	// extra line position
	// var sidebar_width = $('.sidebar').width();
	// $('.extra-line').css('left', (sidebar_width-2)+'px');
});