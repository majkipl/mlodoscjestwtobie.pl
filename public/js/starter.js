var event;
var height;

// Pobieramy aktualny protokół (http lub https)
const protocol = window.location.protocol;

// Pobieramy aktualną domenę strony
const domain = window.location.hostname;

// Tworzymy pełny adres strony z protokołem
const url_home = protocol + '//' + domain;

$(window).load(function(e) {
	event = e || window.event;

	starter.main.init();
	starter.main.resize();
	starter.main.autoscroll();

	starter.effects.hideLoader();
});

$(window).resize(function() {
	starter.main.resize();
});

$(window).scroll(function(e) {
	event = e || window.event;
	starter.main.scroll();
	starter.main.menu_light();
});

function infoFlashBox() {
	var infoContent = $('#info-flash-box span.content').html();

	if (infoContent)
	{
		$('#info-flash-box').css({display:  "block"});
	}

	$('#info-flash-box').click(function ()
	{
		$('#info-flash-box').fadeOut("slow");
	});
	setTimeout("$('#info-flash-box').fadeOut('slow')", 10000);
}

function setInfoFlashBox( value ) {
	var infoContent = $('#info-flash-box span.content');

	infoContent.html( value );
}

var starter = {
    _var: {
		upload_obj : null,
		filter : [],
		owl_products : null,
    },

    _con: {

    },

    main: {
        init: function() {
            starter.main.click();

            starter.main.keyup();

            starter.main.owl();

            starter.main.selectbox();

			starter.main.upload('receipt');
			starter.main.upload('ean');
			starter.main.upload('tip');

			//starter.main.painter();

			//starter.main.timer();

			starter._var.filter["phrase"] = '';
			starter._var.filter["order"] = 0;
			starter._var.filter["sort"] = 1;
			starter._var.filter["limit"] = 10;
			starter._var.filter["offset"] = 0;

			starter.datepicker.init();

			starter.listTipsRender.init();

			starter.main.error_scroll();
        },


		click: function() {
			/*
			$('selector').click(function(){

			});
			*/


			$(document).on('click', '#i_want_more', function(){
				$(this).addClass('hidden');
				$('#form .hideOn').fadeIn(500);
				$('#i_want').val(1);

				return false;
			});

			$(document).on('click', '#form .submit', function(){
				$('#form form#save').submit();

				return false;
			});

			$(document).on('click', '#products .owl-carousel-prev', function(){
				starter._var.owl_products.trigger('prev.owl.carousel');

				return false;
			});

			$(document).on('click', '#products .owl-carousel-next', function(){
				starter._var.owl_products.trigger('next.owl.carousel');

				return false;
			});

			$(document).on('click', '.hamburger', function(){

				$('#site-navigation').toggleClass( "toggled" );

				if( $(this).hasClass("is-active") )
				{
					$(this).removeClass("is-active");
				} else {
					$(this).addClass("is-active");
				}
				return false;
			});

			$(document).on('click', '#contact a.send', function(){
				$.ajax({
				    url: '/kontakt-wyslij/',
				    type: 'POST',
				    cache: false,
				    dataType: "json",
				    data: {
				        "name": $('#contact #name').val(),
				        "email": $('#contact #email').val(),
				        "message": $('#contact #message').val(),
				    },
				    beforeSend: function( xhr )
				    {
				    	$return = true;

						if( !$('#contact #name').val() )
						{
							$return = false;
						}

						$('#contact input, #contact textarea').each(function(key, element){

							$(element).parent().next().text('');

							console.log( $(element).val() );

							if( $(element).attr('type') == 'email' )
							{
								if ( !starter.main.validateEmail( $(element).val() ) )
								{
									$(element).parent().next().text('Wprowadź poprawny adres email');

									console.log( $(element).val() );

									$return = false;
								}
							}

							if( !$(element).val() )
							{
								$(element).parent().next().text('To pole jest wymagane.');

								console.log('input');

								$return = false;
							}

						});

						return $return;
				    },
				    success: function(json)
					{
						$('#contact h3').html( json.message );

						$('#contact .form').hide();
					},
					error: function(x, t, m)
					{
						console.log(x);
						console.log(t);
						console.log(m);
					}

			    });
				return false;
			});


			$(document).on('click', 'a.popup-open', function(){
				var popup = $('section#popup_' + $(this).data('popup'));

				if( popup.hasClass('buy') )
				{
					popup.find('a.shop[href="#"]').each(function( index, item ){
						$(item).addClass('disable').parent().parent().hide();
					});
				}

				popup.addClass('popup-show').fadeIn();

				starter.effects.set_scroll_container_popup( popup.find('.popup-bg') );

				starter.effects.set_center_vertical( $('.popup .mCS_no_scrollbar .mCSB_container') );

				starter.effects.popupContainerRow();

				starter.effects.popupContainerRowCol();

				starter.effects.disableScrolling();

				return false;
			});

			$(document).on('click', 'a.popup-close, a.popup-back', function(){
				var popup = $(this).parents('section');

				popup.removeClass('popup-show').fadeOut();

				starter.effects.enableScrolling();

				return false;
			});

			$(document).on('click', '.menu-container ul li a', function(){
				var attri = $(this).data('href');

				if( $(attri).length > 0 )
				{
					event.preventDefault();
					history.pushState(null,null,$(this).attr("href"));

					var offset = Math.abs($(attri).position().top);
					$('html, body').animate({scrollTop:offset}, 1000);

					return false;
				} else {
					window.location.replace(url_home + $(this).attr("href"));
				}
				return true;
			});


			$(document).on('click', '#getMoreItem', function(){
				starter._var.filter["limit"] = starter._var.filter["limit"] + 10;

				starter.main.get_apps();

				return false;
			});
		},

		keyup: function() {
			$(document).on('keyup', '#applications input#find', function( event ){
				starter._var.filter["phrase"] = $('#applications input#find').val();

				starter.main.get_apps();
			});
		},

		focus: function() {

		},

		resize: function() {
			starter.effects.setFullSizeSection( $('.baner') );

			starter.videoRender.init();

			starter.effects.matchMaxHeight();

			starter.listTipsRender.setHeight();

			starter.effects.popupContainerRow();

			starter.effects.set_center_vertical( $('.popup .mCS_no_scrollbar #mCSB_1_container') );

			starter.effects.e404();
		},

		error_scroll : function() {
			if( $('.has-error input').length ) {
				$('.has-error input').get(0).focus();
			}
		},

		scroll: function() {

		},

		datapicker: function() {

		},

		selectbox: function() {
			if( $("#form select").length > 0 )
			{
				$("#form select").selectbox({
					onOpen: function (inst) {
						$('select#where option').removeAttr('selected');
						$('#sbHolder_' + inst.uid).addClass('focus');
						console.log(inst);
					},
					onClose: function (inst) {
						console.log('onClose');
						$('#sbHolder_' + inst.uid).removeClass('focus');
					},
					onChange: function (val, inst) {
						console.log('val : ' + val);
						console.log(inst);
						if( inst.id == 'category' )
						{
							$.ajax(
							{
								url: '/formularz/pobierz-produkty/',
								dataType: "json",
								data: 	{ id: val },
								type: "POST",
								async: false,
								success: function( json )
								{
									$('select#product option').remove();

									$.each( json.parameters, function(key, value) {
										var option = $('<option>').attr('label', value).attr('value', key).text(value);
										option.appendTo( "select#product" );
									});

									$("select#product").selectbox("detach");

									starter.main.selectbox( $("select#product") );
								},
								error: function(x, t, m)
								{
									console.log('ajax error');
								}
							});
						}
					},
					effect: "slide"
				});
			}
       	},

		get_apps: function () {
			$.ajax(
			{
				url: '/pobierz/',
				dataType: "json",
				data: 	{
					phrase: starter._var.filter["phrase"],
					order: starter._var.filter["order"],
					sort: starter._var.filter["sort"],
					limit: starter._var.filter["limit"],
					offset: starter._var.filter["offset"],
				},
				type: "POST",
				async: false,
				beforeSend: function() {
					$('#applications .items .item').remove();
				},
				success: function( json )
				{
					$.each( json.parameters, function(key, value) {
						starter.effects.createApp( key , value );
					});
				},
				error: function(x, t, m)
				{
					console.log('ajax error');
				}
			});

			console.log( starter._var.filter );
		},

		scroller: function() {

		},

		parallax: function() {

		},
		active_menu: function() {

		},

		submitform: function() {

		},

		cookies: function() {

		},

		sort: function( vArray , filter ) {

		},

		search: function() {

		},

		featherlight: function() {

		},

		checkform: function() {
		},

		upload: function( type ) {

			switch(type)
			{
				case 'receipt':
					name = 'Wgraj zdjęcie paragonu';
					break;
				case 'ean':
					name = 'Wgraj zdjęcie kodu EAN <strong style="color:#e41e13;">wyciętego</strong> z opakowania produktu';
					break;
				case 'tip':
					name = 'Wgraj zdjęcie porady';
					break;
			}

			if( $("#fileuploader"+type).length )
			{
				starter._var.upload_obj = $("#fileuploader"+type).uploadFile({
					url:					url_home + "/upload/typ,"+type,
					returnType:				"json",
					multiple:				false,
					fileName:				"photo",
					autoSubmit:				true,
					maxFileSize:			1024*1024*4,
					maxFileCount:			10,
					dragDrop:				false,
            		multiDragErrorStr: 		"To działanie jest niedostepne.",
            		sizeErrorStr:			"jest za ciężki. Maksymalna waga pliku to ",
					allowedTypes:			"png,gif,jpg,jpeg",
					uploadStr:				name,
					showAbort: 				false,
					onLoad: 				function (obj) {},
		            onSelect: 				function (files) {
		            							$('#form .uploads-' + type + ' + span.error-post').text('');
		            						},
            		onSubmit:				function(files){},
					onSuccess:				function(files,json,xhr,pd) {
												if ( json.isSuccess )
												{
													$('#form .uploads-' + type + ' .ajax-file-upload-progress').hide();
													$('#form .uploads-' + type + '').css({'background-image': 'url("/static/uploads/' + type + '/750x750-' + json.parameters.file + '")'});
													$('#form .uploads-' + type + ' #img_' + type).val( json.parameters.file );
													$('#form .uploads-' + type + ' #fileuploader' + type).remove();
													$('#form .uploads-' + type + ' + span.error-post').text('');
													$('#form .uploads-' + type).parent().next().text( '' );
												} else {
													console.log('ERROR');
													$('#form .uploads-' + type).parent().addClass('error');

													console.log();

													$('#form .uploads-' + type).parent().next().text( json.parameters.post['img_' + type] );
													//$('#form .uploads-' + type + ' + span.error-post').text('erro'); //json.parameters.post['img_' + type]
												}
											},
					beforeUploadAll: 		function(){},
					onError: 				function(files,status,errMsg,pd) {
												//console.log(errMsg);
												$('#form .uploads-' + type + ' + span.error-post').text(errMsg);
											},
					onCancel: 				function (files, pd) {},
            		onAbort: 				function (files, pd) {},
				});
			}
		},

		owl: function() {

			if( $(".owl-carousel").length > 0 )
			{
	            starter._var.owl_products = $(".owl-carousel").owlCarousel({
				    loop:true,
				    margin:10,
				    nav:false,
				    dots:true,
				    margin: 0,
				    responsive:{
				        0: {
				            items:1,
				            slideBy: 1,
				        },
				    	768: {
				            items:2,
				            slideBy: 1,
				        },
				        992: {
				            items:3,
				            slideBy: 1,
				        },
				        1200: {
				            items:3,
				            slideBy: 1,
				        }
				    }
	        	});
	        }
		},

		autoscroll: function() {
			switch( window.location.pathname )
			{
				case '/':
					var attri = '#baner';
					break;
				case '/nagrody/':
					var attri = '#prizes';
					break;
				case '/wez-udzial/':
					var attri = '#take';
					break;
				case '/zgloszenia/':
					var attri = '#applications';
					break;
				case '/zgloszenia-tygodnia/':
					var attri = '#week';
					break;
				case '/nasze-produkty/':
					var attri = '#products';
					break;
				case '/kontakt/':
					var attri = '#contact';
					break;
			}

			if( (attri != undefined) && ($(attri).length > 0))
			{
				var offset = Math.abs($(attri).position().top);

				$('html, body').animate({scrollTop:$(attri).position().top}, 1000);
			}
		},

		timer: function() {

		},

		menu_light_section: function( section ) {
			var height = $(window).scrollTop() + $(window).height() / 2;

			if ( $(section).length > 0 )
			{
				if( height > $(section).position().top && height < $(section).position().top + $(section).height() ){
					if( $('.menu-container ul li a[data-href="'+section+'"]').length > 0 ) {
						var ob = $('.menu-container ul li a[data-href="'+section+'"]');
						ob.parent().addClass('active');
						pathname = ob.attr("href");
					} else {
						pathname = '/';
					}

					event.preventDefault();
					history.pushState(null,null,pathname);
				}
			}
		},

		menu_light: function(){
			$('.menu-container ul li').removeClass('active');

			starter.main.menu_light_section('#baner');
			starter.main.menu_light_section('#prizes');
			starter.main.menu_light_section('#take');
			starter.main.menu_light_section('#week');
			starter.main.menu_light_section('#applications');
			starter.main.menu_light_section('#products');
			starter.main.menu_light_section('#contact');
		},

		validateEmail: function(sEmail) {
		    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		    if (filter.test(sEmail)) {
		        return true;
		    } else {
		        return false;
		    }
		},
  	},

	listTipsRender: {
		init: function() {
			if( $('#applications.applications .list .items').length ){
				starter.main.get_apps();
				starter.listTipsRender.setHeight();
			}
		},

		setHeight: function() {
			$('#applications .application .image, #applications .application .video.youtube, #applications .application .video.vimeo, #applications .application .video.facebook').css({
				'height': $('.item .application').width() + 'px',
			});

			if( starter.rwd.isXs() ) {
				$('#week .application .image').css({
					'height': $('#week .application').width() + 'px',
				});
			} else {
				if( starter.rwd.isSm() ) {
					$('#week .application .image').css({
						'height': '345px',
					});
				} else if ( starter.rwd.isMd() ) {
					$('#week .application .image').css({
						'height': '212px',
					});
					$('#week .application.last .image').css({
						'height': '455px',
					});
				} else if ( starter.rwd.isLg() ) {
					$('#week .application .image').css({
						'height': '165px',
					});
					$('#week .application.last .image').css({
						'height': '360px',
					});
				}
			}
		}
	},

	videoRender: {
		init: function() {

			if( $('#bgvid').length ) {
				var ww = $(window).width();
				var wh = $(window).height();

				var rw = ww/wh;
				var rv = 1920/1080;

				console.log( rw + ' / ' + rv );

				//if( ww > wh ) { //landscape
				if( rw > rv ) { //landscape
					$('#bgvid').css({
						'width': ww + 'px',
						'height': (ww * 1080 / 1920) + 'px',
						'margin-top': '-' + (ww * 1080 / 1920 / 2) + 'px',
						'margin-left': '-' + (ww / 2) + 'px',
					});
				} else { //portrait
					$('#bgvid').css({
						'height': wh + 'px',
						'width': (wh * 1920 / 1080) + 'px',
						'margin-top': '-' + (wh / 2) + 'px',
						'margin-left': '-' + (wh * 1920 / 1080 / 2) + 'px',
					});
				}
			}
		}
	},

	datepicker: {
		init: function() {
			if( $('input#birthday').length ) {
				$('#birthday').datetimepicker({
					format: 'DD-MM-YYYY',
					inline: true,
					locale: 'pl'
				});
				$('input#firstname').focus();

				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();

				if( dd > 9)
					today_string = dd + '-' + mm + '-' + yyyy;
				else
					today_string = '0' + dd + '-' + mm + '-' + yyyy;

				if( today_string == $('#birthday').val() )
					$('#birthday').val('');
			};
		}
	},

  	rwd: {
	  	isXs: function() {
  			if ( $(window).width() < 768 )
	  			return true;
  			else
	  			return false;
	  	},

	  	isSm: function() {
  			if ( ($(window).width() < 992) && ($(window).width() >= 768) )
	  			return true;
  			else
	  			return false;
	  	},

	  	isMd: function() {
  			if ( ($(window).width() < 1200) && ($(window).width() >= 992) )
	  			return true;
  			else
	  			return false;
	  	},
	  	isLg: function() {
  			if ( $(window).width() >= 1200 )
	  			return true;
  			else
	  			return false;
	  	}
  	},

  	effects: {
  		createApp: function(key, value) {
  			var item = $('<div>').addClass('col-xs-12 col-sm-6 col-md-4 col-lg-5ths item');
  				var application = $('<div>').addClass('application');

				if( value.fotoimg ) {
					var image = $('<div>').addClass('image').attr('style', "background-image : url('" + url_home  + "/static/uploads/tip/455x455-" + value.fotoimg + "');");
					image.appendTo( application );
				} else if( value.video_url ) {
					if( value.video_type == 1 ) {
						var video = $('<div>').addClass('video youtube').attr('style', "background-image: url('https://img.youtube.com/vi/" + value.video_image_id + "/default.jpg');");
					} else if( value.video_type == 2 ) {
						var video = $('<div>').addClass('video vimeo').attr('style', "background-image: url('https://i.vimeocdn.com/video/" + value.video_image_id + "_640.jpg');");
					} else if( value.video_type == 3 ) {
						var video = $('<div>').addClass('video facebook').attr('style', "background-image: url('https://graph.facebook.com/" + value.video_image_id + "/picture');");
					}
					video.appendTo( application );
				}

				var a = $('<a>').attr('title',value.title).attr('href',url_home + '/zgloszenie/id,' + value.id);
					var c_table = $('<div>').addClass('c-table');
						var c_row = $('<div>').addClass('c-row');
							var c_cell = $('<div>').addClass('c-cell').text('zobacz');
							c_cell.appendTo( c_row );
						c_row.appendTo( c_table );
					c_table.appendTo( a );
				a.appendTo( application );

				var span = $('<span>').text(value.firstname + ' ' + value.lastname);
				span.appendTo( application );

				var fb = $('<a>').addClass('fb').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + url_home + '/zgloszenie/id,' + value.id);
				fb.appendTo( application );

			application.appendTo( item );
			item.appendTo( "#applications .items" );
  		},

		hideLoader: function() {
			$('#loader').fadeOut();
		},

		matchMaxHeight: function() {
			$('#baner .steps .step').matchMaxHeight();
			$('#prizes .nty .nty-equal-height').matchMaxHeight();
			$('#take .step').matchMaxHeight();
			$('#products .item h4').matchMaxHeight();
			$('#products .item ul').matchMaxHeight();
		},

		setFullSizeSection: function( section ) {
			section.css({
				'height': $(window).height() + 'px',
				'width': $(window).width() + 'px',
			});
		},

		popupContainerRow: function() {
			$('.popup-container-row').css({
				'height': $(window).height() - 40 + 'px'
			});
		},

		popupContainerRowCol: function() {
			$('.popup-container-row-col').matchMaxHeight();
		},

		e404: function() {
			if( $('section#e404').length ) {
				$('section#e404').css({
					'width': $(window).width() + 'px',
					'height': $(window).height() + 'px',
				});
			}
		},

		set_center_vertical: function( items ) {
			items.each(function(){
				var itm = $(this);

				itm.css( {
					"position": "absolute",
				} );

				itm.css( {
					"top": '50%',
					"margin-top": '-' + (itm.height()/2) + 'px',
				} );

			});
		},

		set_scroll_container_popup: function( obj ) {
			obj.mCustomScrollbar({
				callbacks:{
				    onCreate:function(){
				      console.log("onCreate");
				    },
				    onInit:function(){
				      console.log("onInit");
				    }
				},
			});
		},

		disableScrolling: function() {
		    var x = window.scrollX;
		    var y = window.scrollY;
		    window.onscroll = function() {
		    	window.scrollTo(x, y);
		    };
		},

		enableScrolling: function () {
		    window.onscroll = function() {

		    };
		}

  },


};

//plugin to match all heights equal to max height in selection
(function ($) {
	$.fn.matchMaxHeight = function () {
		var items = $(this);
		$(items).attr('style', '');
		$(items).css({});
		var max = 0;
		for(var i=0; i<items.length ; i++){
			max = max < $(items[i]).height() ?
			$(items[i]).height() : max;

		}
		$(items).css({'display': 'block', 'height': ''+max+'px'});
	}
})(jQuery);

