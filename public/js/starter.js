var event;
var height;

// Pobieramy aktualny protokół (http lub https)
const protocol = window.location.protocol;

// Pobieramy aktualną domenę strony
const domain = window.location.hostname;

// Tworzymy pełny adres strony z protokołem
const url_home = protocol + '//' + domain;

$(window).load(function (e) {
    event = e || window.event;

    starter.main.init();
    starter.main.resize();
    starter.main.autoscroll();

    starter.effects.hideLoader();
});

$(window).resize(function () {
    starter.main.resize();
});

$(window).scroll(function (e) {
    event = e || window.event;
    starter.main.scroll();
    starter.main.menu_light();
});

function infoFlashBox() {
    var infoContent = $('#info-flash-box span.content').html();

    if (infoContent) {
        $('#info-flash-box').css({display: "block"});
    }

    $('#info-flash-box').click(function () {
        $('#info-flash-box').fadeOut("slow");
    });
    setTimeout("$('#info-flash-box').fadeOut('slow')", 10000);
}

function setInfoFlashBox(value) {
    var infoContent = $('#info-flash-box span.content');

    infoContent.html(value);
}

var starter = {
    _var: {
        upload_obj: null,
        filter: [],
        owl_products: null,
        error: []
    },

    _con: {},

    main: {
        init: function () {
            starter.main.onClick();
            starter.main.onChange();
            starter.main.onSubmit();

            starter.main.keyup();

            starter.main.owl();

            starter.main.selectbox();

            // starter.main.upload('receipt');
            // starter.main.upload('ean');
            // starter.main.upload('tip');

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


        onClick: function () {
            /*
            $('selector').click(function(){

            });
            */


            $(document).on('click', '#i_want_more', function () {
                $(this).addClass('hidden');
                $('#form .hideOn').fadeIn(500);
                $('#i_want').val('yes');

                return false;
            });

            $(document).on("click", "button.button-uploads", function () {
                $(this).prev().find("input[type=file]").trigger("click");
            });

            $(document).on('click', '#form .submit', function () {
                $('#form form#save').submit();

                return false;
            });

            $(document).on('click', '#products .owl-carousel-prev', function () {
                starter._var.owl_products.trigger('prev.owl.carousel');

                return false;
            });

            $(document).on('click', '#products .owl-carousel-next', function () {
                starter._var.owl_products.trigger('next.owl.carousel');

                return false;
            });

            $(document).on('click', '.hamburger', function () {

                $('#site-navigation').toggleClass("toggled");

                if ($(this).hasClass("is-active")) {
                    $(this).removeClass("is-active");
                } else {
                    $(this).addClass("is-active");
                }
                return false;
            });

            $(document).on('click', '#contact a.send', function() {
                $(this).closest('form').submit();
                return false;
            });

            // $(document).on('click', '#contact a.send', function () {
            //     $.ajax({
            //         url: '/kontakt-wyslij/',
            //         type: 'POST',
            //         cache: false,
            //         dataType: "json",
            //         data: {
            //             "name": $('#contact #name').val(),
            //             "email": $('#contact #email').val(),
            //             "message": $('#contact #message').val(),
            //         },
            //         beforeSend: function (xhr) {
            //             $return = true;
            //
            //             if (!$('#contact #name').val()) {
            //                 $return = false;
            //             }
            //
            //             $('#contact input, #contact textarea').each(function (key, element) {
            //
            //                 $(element).parent().next().text('');
            //
            //                 console.log($(element).val());
            //
            //                 if ($(element).attr('type') == 'email') {
            //                     if (!starter.main.validateEmail($(element).val())) {
            //                         $(element).parent().next().text('Wprowadź poprawny adres email');
            //
            //                         console.log($(element).val());
            //
            //                         $return = false;
            //                     }
            //                 }
            //
            //                 if (!$(element).val()) {
            //                     $(element).parent().next().text('To pole jest wymagane.');
            //
            //                     console.log('input');
            //
            //                     $return = false;
            //                 }
            //
            //             });
            //
            //             return $return;
            //         },
            //         success: function (json) {
            //             $('#contact h3').html(json.message);
            //
            //             $('#contact .form').hide();
            //         },
            //         error: function (x, t, m) {
            //             console.log(x);
            //             console.log(t);
            //             console.log(m);
            //         }
            //
            //     });
            //     return false;
            // });


            $(document).on('click', 'a.popup-open', function () {
                var popup = $('section#popup_' + $(this).data('popup'));

                if (popup.hasClass('buy')) {
                    popup.find('a.shop[href="#"]').each(function (index, item) {
                        $(item).addClass('disable').parent().parent().hide();
                    });
                }

                popup.addClass('popup-show').fadeIn();

                starter.effects.set_scroll_container_popup(popup.find('.popup-bg'));

                starter.effects.set_center_vertical($('.popup .mCS_no_scrollbar .mCSB_container'));

                starter.effects.popupContainerRow();

                starter.effects.popupContainerRowCol();

                starter.effects.disableScrolling();

                return false;
            });

            $(document).on('click', 'a.popup-close, a.popup-back', function () {
                var popup = $(this).parents('section');

                popup.removeClass('popup-show').fadeOut();

                starter.effects.enableScrolling();

                return false;
            });

            $(document).on('click', '.menu-container ul li a', function () {
                var attri = $(this).data('href');

                if ($(attri).length > 0) {
                    event.preventDefault();
                    history.pushState(null, null, $(this).attr("href"));

                    var offset = Math.abs($(attri).position().top);
                    $('html, body').animate({scrollTop: offset}, 1000);

                    return false;
                } else {
                    window.location.replace(url_home + $(this).attr("href"));
                }
                return true;
            });


            $(document).on('click', '#getMoreItem', function () {
                starter._var.filter["offset"] = starter._var.filter["offset"] + 10;

                starter.main.get_apps();

                return false;
            });
        },

        onChange: function () {
            $(document).on('change', '.input, .textarea, .checkbox, .file', function () {
                const item = $(this);
                const value = $(this).val().trim();
                const name = $(this).attr('name');
                const iWant = $('#i_want').val() ? 1 : 0;

                // console.log(name);

                if (item.hasClass('upload-file')) {
                    const fileUpload = item[0].files[0];
                    const fieldId = item.attr('id');

                    const errorDiv = $(`.error-${fieldId}`);

                    errorDiv.text('');

                    if (fileUpload) {
                        if (fileUpload.size <= 4 * 1024 * 1024) {
                            const extension = fileUpload.name.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png'].indexOf(extension) !== -1) {
                                let reader = new FileReader();
                                reader.onload = function (event) {
                                    $(`#${fieldId}_thumb`).attr('src', event.target.result).parent().removeClass('hidden').next().addClass('hidden');
                                }
                                reader.readAsDataURL(fileUpload);
                            } else {
                                console.log('extension error');
                                // // Wyświetlenie komunikatu o błędzie
                                // errorDiv.text('Można wybrać tylko pliki graficzne JPG, JPEG lub PNG');
                                // // Wyczyszczenie pola wyboru pliku
                                // item.val('');
                            }
                        } else {
                            console.log('size error');
                            // Wyświetlenie komunikatu o błędzie
                            // errorDiv.text('Rozmiar pliku nie może przekraczać 4 MB');
                            // Wyczyszczenie pola wyboru pliku
                            // item.val('');
                        }
                    }
                }

                const valid = () => {
                    switch (name) {
                        case 'firstname':
                            return starter.main.validator.isName(value, 'Imię');
                        case 'lastname':
                            return starter.main.validator.isName(value, 'Nazwisko');
                        case 'name':
                            return starter.main.validator.isName(value, 'Imię i nazwisko');
                        case 'address':
                            return starter.main.validator.isAddress(value, 'Ulica');
                        case 'city':
                            return starter.main.validator.isCity(value, 'Miasto');
                        case 'zip':
                            return starter.main.validator.isZip(value, 'Kod pocztowy');
                        case 'email':
                            return starter.main.validator.isEmail(value, 'Adres e-mail');
                        case 'phone':
                            return starter.main.validator.isPhone(value, 'Telefon');
                        case 'receiptnb':
                            return starter.main.validator.isReceiptNumber(value, 'Numer dowodu zakupu');
                        case 'category':
                            return starter.main.validator.isCategory(value, 'Kategoria');
                        case 'product':
                            return starter.main.validator.isProduct(value, 'Zakupiony produkt');
                        case 'shop':
                            return starter.main.validator.isShop(value, 'Rodzaj sklepu');
                        case 'whence':
                            return starter.main.validator.isWhere(value, 'Skąd dowiedziałeś się o promocji?');
                        case 'legal_1':
                            return starter.main.validator.isLegal(item);
                        case 'legal_2':
                            return starter.main.validator.isLegal(item);
                        case 'legal_3':
                            return starter.main.validator.isLegal(item);
                        case 'legal_4':
                            return starter.main.validator.isLegal(item);
                        case 'title':
                            return iWant ? starter.main.validator.isName(value, 'Tytuł zgłoszenia') : true;
                        case 'message':
                            return iWant ? starter.main.validator.isMessage(value, 'Wiadomość') : true;
                        case 'video_url':
                            return iWant ? starter.main.validator.isVideoUrl(value, 'Link do filmu') : true;
                        case 'img_tip':
                            return iWant ? starter.main.validator.isImgTip(item, 'Zdjęcie porady') : true;
                        case 'img_ean':
                            return starter.main.validator.isFile(item, 'Zdjęcie kodu ean');
                        case 'img_receipt':
                            return starter.main.validator.isFile(item, 'Zdjęcie paragonu');
                    }
                }

                if (valid() !== true) {
                    $(`.error-${name}`).text(valid());
                    starter._var.error[name] = valid();
                } else {
                    $(`.error-${name}`).text('');
                    delete starter._var.error[name];
                }

            });
        },

        onSubmit: function () {
            $(document).on('submit', '#formContact form', function () {
                const fields = starter.getFields($(this).closest('form'));
                const url = $(this).closest('form').attr('action');

                axios({
                    method: 'post',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: fields,
                }).then(function (response) {
                    $('#contact h3').html(response.data.results.message);
                    $('#contact .form').hide();
                }).catch(function (error) {
                    $(`.error-post`).text('');
                    if (error.response) {
                        Object.keys(error.response.data.errors).map((item) => {
                            $(`.error-${item}`).text(error.response.data.errors[item][0]);
                        });
                    } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        console.log(error.request);
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log('Error', error.message);
                    }
                });

                return false;
            });

            $(document).on('submit', '#form form', function () {
                // $('.input, .textarea, .checkbox, .file').trigger('change');

                // console.log(starter._var.error);

                if (Object.keys(starter._var.error).length === 0) {
                    const fields = starter.getFields($(this).closest('form'));
                    const url = $(this).closest('form').attr('action');

                    console.log(fields);
                    console.log(url);

                    const formData = new FormData();

                    for (const field in fields) {
                        formData.append(field, fields[field]);
                    }

                    console.log(formData.get('firstname'));

                    axios({
                        method: 'post',
                        url: url,
                        headers: {
                            'content-type': 'multipart/form-data',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                    }).then(function (response) {
                        window.location = response.data.results.url;
                    }).catch(function (error) {
                        $(`.error-post`).text('');
                        if (error.response) {
                            Object.keys(error.response.data.errors).map((item) => {
                                $(`.error-${item}`).text(error.response.data.errors[item][0]);
                            });
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                    });
                } else {
                    $('.error-post').text('');
                    for (let key in starter._var.error) {
                        if (starter._var.error.hasOwnProperty(key)) {
                            let value = starter._var.error[key];
                            $('.error-' + key).text(value);
                        }
                    }
                }

                return false;
            });
        },

        keyup: function () {
            $(document).on('keyup', '#applications input#find', function (event) {
                starter._var.filter["phrase"] = $('#applications input#find').val();

                starter.main.get_apps();
            });
        },

        focus: function () {

        },

        resize: function () {
            starter.effects.setFullSizeSection($('.baner'));

            starter.videoRender.init();

            starter.effects.matchMaxHeight();

            starter.listTipsRender.setHeight();

            starter.effects.popupContainerRow();

            starter.effects.set_center_vertical($('.popup .mCS_no_scrollbar #mCSB_1_container'));

            starter.effects.e404();
        },

        validator: {
            isName: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length < 3 || value.length > 128) {
                    return `Pole ${name} musi mieć od 3 do 128 znaków.`;
                } else if (!/^[\p{L}\s-]+$/u.test(value)) {
                    return `Pole ${name} może zawierać tylko litery.`;
                } else {
                    return true;
                }
            },
            isAddress: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length > 255) {
                    return `Pole ${name} może mieć maksymalnie 255 znaków.`;
                } else {
                    return true;
                }
            },
            isCity: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length < 2 || value.length > 64) {
                    return `Pole ${name} musi mieć od 2 do 64 znaków.`;
                } else {
                    return true;
                }
            },
            isZip: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (!/^[0-9]{2}-[0-9]{3}$/.test(value)) {
                    return 'Wprowadź poprawny kod pocztowy.';
                } else {
                    return true;
                }
            },
            isPhone: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (!/^\+48(\s)?([1-9]\d{8}|[1-9]\d{2}\s\d{3}\s\d{3}|[1-9]\d{1}\s\d{3}\s\d{2}\s\d{2}|[1-9]\d{1}\s\d{2}\s\d{3}\s\d{2}|[1-9]\d{1}\s\d{2}\s\d{2}\s\d{3}|[1-9]\d{1}\s\d{4}\s\d{2}|[1-9]\d{2}\s\d{2}\s\d{2}\s\d{2}|[1-9]\d{2}\s\d{3}\s\d{2}|[1-9]\d{2}\s\d{4})$/.test(value)) {
                    return 'Wprowadź poprawny numer telefonu.';
                } else {
                    return true;
                }
            },
            isEmail: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length > 255) {
                    return `Pole ${name} może mieć maksymalnie 255 znaków.`;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    return 'Wprowadź poprawny adres email.';
                } else {
                    return true;
                }
            },
            isCategory: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (isNaN(value) || parseInt(value) < 1 || parseInt(value) > 9) {
                    return 'Wybierz kategorię.';
                } else {
                    return true;
                }
            },
            isProduct: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (isNaN(value) || parseInt(value) < 1 || parseInt(value) > 93) {
                    return 'Wybierz produkt.';
                } else {
                    return true;
                }
            },
            isShop: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (isNaN(value) || parseInt(value) < 1 || parseInt(value) > 30) {
                    return 'Wybierz rodzaj sklepu.';
                } else {
                    return true;
                }
            },
            isReceiptNumber: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length < 1 || value.length > 32) {
                    return `Pole ${name} musi mieć od 1 do 32 znaków.`;
                } else {
                    return true;
                }
            },
            isWhere: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (isNaN(value) || parseInt(value) < 1 || parseInt(value) > 7) {
                    return 'Wybierz opcje.';
                } else {
                    return true;
                }
            },
            isLegal: (item) => {
                if (item.val() === "") {
                    return `Pole jest wymagane.`;
                } else if (!item.prop('checked')) {
                    return `Pole jest wymagane.`;
                } else {
                    return true;
                }
            },
            isMessage: (value, name) => {
                if (value === "") {
                    return `Pole ${name} jest wymagane.`;
                } else if (value.length < 3 || value.length > 4096) {
                    return `Pole ${name} musi mieć od 3 do 4096 znaków.`;
                } else {
                    return true;
                }
            },
            isVideoUrl: (value, name) => {
                const urlPattern = /^(https?:\/\/)?(www\.)?(youtube\.com|vimeo\.com)\/(watch\?v=|video\/)?([a-zA-Z0-9_-]{11}|[0-9]{5,11})$/;

                if ($('#img_tip').files[0]) {
                    return `Twoje zgłoszenie może zawierać tekst ze zdjęciem lub tekst z video.`;
                } else {
                    if (value === "") {
                        return `Pole ${name} jest wymagane.`;
                    } else if (value.length > 255) {
                        return `Pole ${name} musi mieć max. 255 znaków.`;
                    } else if (!urlPattern.test(value)) {
                        return `Pole ${name} przyjmuje linki z Youtube lub Vimeo.`;
                    } else {
                        return true;
                    }
                }
            },
            isFile: (file, name) => {
                const extension = file[0]?.files[0]?.name.split('.').pop().toLowerCase();
                if (file[0].files.length === 0) {
                    return `Pole ${name} jest wymagane.`;
                } else if (file[0].files[0].size > 4 * 1024 * 1024) {
                    return `Rozmiar pliku nie może przekraczać 4 MB`;
                } else if (['jpg', 'jpeg', 'png'].indexOf(extension) === -1) {
                    return `Można wybrać tylko pliki graficzne JPG, JPEG lub PNG`;
                } else {
                    return true;
                }
            },
            isImgTip: (file, name) => {
                const extension = file[0]?.files[0]?.name.split('.').pop().toLowerCase();
                if ($('#video_url').val() === "" && file[0].files.length === 0) {
                    return `Pole ${name} jest wymagane.`;
                } else if ($('#video_url').val() !== "" && file[0].files.length !== 0) {
                    return `Twoje zgłoszenie może zawierać tekst ze zdjęciem lub tekst z video.`;
                } else if (file[0].files[0].size > 4 * 1024 * 1024) {
                    return `Rozmiar pliku nie może przekraczać 4 MB`;
                } else if (['jpg', 'jpeg', 'png'].indexOf(extension) === -1) {
                    return `Można wybrać tylko pliki graficzne JPG, JPEG lub PNG`;
                } else {
                    return true;
                }
            },
        },

        error_scroll: function () {
            if ($('.has-error input').length) {
                $('.has-error input').get(0).focus();
            }
        },

        scroll: function () {

        },

        datapicker: function () {

        },

        selectbox: function () {
            if ($("#form select").length > 0) {
                $("#form select").selectbox({
                    onOpen: function (inst) {
                        $('select#where option').removeAttr('selected');
                        $('#sbHolder_' + inst.uid).addClass('focus');
                    },
                    onClose: function (inst) {
                        $('#sbHolder_' + inst.uid).removeClass('focus');
                    },
                    onChange: function (val, inst) {
                        if (inst.id == 'category') {
                            if (val > 0) {
                                $.ajax(
                                    {
                                        url: '/api/product/category/' + val,
                                        dataType: "json",
                                        type: "GET",
                                        async: false,
                                        success: function (json) {
                                            $('select#product option').remove();

                                            let option = $('<option>').attr('label', 'Produkt').text('Produkt');
                                            option.appendTo("select#product");

                                            $.each(json.rows, function (key, value) {
                                                let option = $('<option>').attr('label', value.name).attr('value', value.id).text(value.name);
                                                option.appendTo("select#product");
                                            });

                                            $("select#product").selectbox("detach");

                                            starter.main.selectbox($("select#product"));
                                            $(`.error-category`).text('');
                                        },
                                        error: function (x, t, m) {
                                            console.log('ajax error');
                                        }
                                    });
                            } else {
                                $(`.error-category`).text('Wybierz kategorię.');

                            }

                        }
                    },
                    effect: "slide"
                });
            }
        },

        get_apps: function () {
            axios({
                method: 'post',
                url: '/api/contest/verified',
                data: {
                    phrase: starter._var.filter["phrase"],
                    order: starter._var.filter["order"],
                    sort: starter._var.filter["sort"],
                    limit: starter._var.filter["limit"],
                    offset: starter._var.filter["offset"],
                },
            }).then(function (response) {
                $.each(response.data.rows, function (key, value) {
                    starter.effects.createApp(key, value);
                });
            }).catch(function (error) {
                if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    console.log(error.request);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                }
            });
            // $.ajax({
            //     url: '/pobierz/',
            //     dataType: "json",
            //     data: {
            //         phrase: starter._var.filter["phrase"],
            //         order: starter._var.filter["order"],
            //         sort: starter._var.filter["sort"],
            //         limit: starter._var.filter["limit"],
            //         offset: starter._var.filter["offset"],
            //     },
            //     type: "POST",
            //     async: false,
            //     beforeSend: function () {
            //         $('#applications .items .item').remove();
            //     },
            //     success: function (json) {
            //         $.each(json.parameters, function (key, value) {
            //             starter.effects.createApp(key, value);
            //         });
            //     },
            //     error: function (x, t, m) {
            //         console.log('ajax error');
            //     }
            // });

            console.log(starter._var.filter);
        },

        scroller: function () {

        },

        parallax: function () {

        },
        active_menu: function () {

        },

        submitform: function () {

        },

        cookies: function () {

        },

        sort: function (vArray, filter) {

        },

        search: function () {

        },

        featherlight: function () {

        },

        checkform: function () {
        },

        upload: function (type) {

            switch (type) {
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

            if ($("#fileuploader" + type).length) {
                starter._var.upload_obj = $("#fileuploader" + type).uploadFile({
                    url: url_home + "/upload/typ," + type,
                    returnType: "json",
                    multiple: false,
                    fileName: "photo",
                    autoSubmit: true,
                    maxFileSize: 1024 * 1024 * 4,
                    maxFileCount: 10,
                    dragDrop: false,
                    multiDragErrorStr: "To działanie jest niedostepne.",
                    sizeErrorStr: "jest za ciężki. Maksymalna waga pliku to ",
                    allowedTypes: "png,gif,jpg,jpeg",
                    uploadStr: name,
                    showAbort: false,
                    onLoad: function (obj) {
                    },
                    onSelect: function (files) {
                        $('#form .uploads-' + type + ' + span.error-post').text('');
                    },
                    onSubmit: function (files) {
                    },
                    onSuccess: function (files, json, xhr, pd) {
                        if (json.isSuccess) {
                            $('#form .uploads-' + type + ' .ajax-file-upload-progress').hide();
                            $('#form .uploads-' + type + '').css({'background-image': 'url("/static/uploads/' + type + '/750x750-' + json.parameters.file + '")'});
                            $('#form .uploads-' + type + ' #img_' + type).val(json.parameters.file);
                            $('#form .uploads-' + type + ' #fileuploader' + type).remove();
                            $('#form .uploads-' + type + ' + span.error-post').text('');
                            $('#form .uploads-' + type).parent().next().text('');
                        } else {
                            console.log('ERROR');
                            $('#form .uploads-' + type).parent().addClass('error');

                            console.log();

                            $('#form .uploads-' + type).parent().next().text(json.parameters.post['img_' + type]);
                        }
                    },
                    beforeUploadAll: function () {
                    },
                    onError: function (files, status, errMsg, pd) {
                        //console.log(errMsg);
                        $('#form .uploads-' + type + ' + span.error-post').text(errMsg);
                    },
                    onCancel: function (files, pd) {
                    },
                    onAbort: function (files, pd) {
                    },
                });
            }
        },

        owl: function () {

            if ($(".owl-carousel").length > 0) {
                starter._var.owl_products = $(".owl-carousel").owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: false,
                    dots: true,
                    margin: 0,
                    responsive: {
                        0: {
                            items: 1,
                            slideBy: 1,
                        },
                        768: {
                            items: 2,
                            slideBy: 1,
                        },
                        992: {
                            items: 3,
                            slideBy: 1,
                        },
                        1200: {
                            items: 3,
                            slideBy: 1,
                        }
                    }
                });
            }
        },

        autoscroll: function () {
            switch (window.location.pathname) {
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

            if ((attri != undefined) && ($(attri).length > 0)) {
                var offset = Math.abs($(attri).position().top);

                $('html, body').animate({scrollTop: $(attri).position().top}, 1000);
            }
        },

        timer: function () {

        },

        menu_light_section: function (section) {
            var height = $(window).scrollTop() + $(window).height() / 2;

            if ($(section).length > 0) {
                if (height > $(section).position().top && height < $(section).position().top + $(section).height()) {
                    if ($('.menu-container ul li a[data-href="' + section + '"]').length > 0) {
                        var ob = $('.menu-container ul li a[data-href="' + section + '"]');
                        ob.parent().addClass('active');
                        pathname = ob.attr("href");
                    } else {
                        pathname = '/';
                    }

                    event.preventDefault();
                    history.pushState(null, null, pathname);
                }
            }
        },

        menu_light: function () {
            $('.menu-container ul li').removeClass('active');

            starter.main.menu_light_section('#baner');
            starter.main.menu_light_section('#prizes');
            starter.main.menu_light_section('#take');
            starter.main.menu_light_section('#week');
            starter.main.menu_light_section('#applications');
            starter.main.menu_light_section('#products');
            starter.main.menu_light_section('#contact');
        },

        validateEmail: function (sEmail) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        },
    },

    getFields: function ($form) {
        const inputs = $form.find('.input');
        const textareas = $form.find('.textarea');
        const checkboxes = $form.find('.checkbox');
        const files = $form.find('.file');

        const fields = {};

        $.each(inputs, function (index, item) {
            fields[$(item).attr('name')] = $(item).val();
        });

        $.each(textareas, function (index, item) {
            fields[$(item).attr('name')] = $(item).val();
        });

        $.each(checkboxes, function (index, item) {
            if ($(item).prop('checked')) {
                fields[$(item).attr('name')] = $(item).val();
            }
        });

        $.each(files, function (index, item) {
            if (item.files[0]) {
                fields[$(item).attr('name')] = item.files[0];
            }
        })

        fields['_token'] = $form.find('input[name=_token]').val();

        return fields;
    },

    listTipsRender: {
        init: function () {
            if ($('#applications.applications .list .items').length) {
                starter.main.get_apps();
                starter.listTipsRender.setHeight();
            }
        },

        setHeight: function () {
            $('#applications .application .image, #applications .application .video.youtube, #applications .application .video.vimeo, #applications .application .video.facebook').css({
                'height': $('.item .application').width() + 'px',
            });

            if (starter.rwd.isXs()) {
                $('#week .application .image').css({
                    'height': $('#week .application').width() + 'px',
                });
            } else {
                if (starter.rwd.isSm()) {
                    $('#week .application .image').css({
                        'height': '345px',
                    });
                } else if (starter.rwd.isMd()) {
                    $('#week .application .image').css({
                        'height': '212px',
                    });
                    $('#week .application.last .image').css({
                        'height': '455px',
                    });
                } else if (starter.rwd.isLg()) {
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
        init: function () {

            if ($('#bgvid').length) {
                var ww = $(window).width();
                var wh = $(window).height();

                var rw = ww / wh;
                var rv = 1920 / 1080;

                console.log(rw + ' / ' + rv);

                //if( ww > wh ) { //landscape
                if (rw > rv) { //landscape
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
        init: function () {
            if ($('input#birthday').length) {
                $('#birthday').datetimepicker({
                    format: 'DD-MM-YYYY',
                    inline: true,
                    locale: 'pl',
                    maxDate: moment().subtract(18, 'years')
                });
                $('input#firstname').focus();

                // var today = new Date();
                // var dd = today.getDate();
                // var mm = today.getMonth()+1; //January is 0!
                // var yyyy = today.getFullYear();
                //
                // if( dd > 9)
                // 	today_string = dd + '-' + mm + '-' + yyyy;
                // else
                // 	today_string = '0' + dd + '-' + mm + '-' + yyyy;
                //
                // if( today_string == $('#birthday').val() )
                // 	$('#birthday').val('');
            }
            ;
        }
    },

    rwd: {
        isXs: function () {
            if ($(window).width() < 768)
                return true;
            else
                return false;
        },

        isSm: function () {
            if (($(window).width() < 992) && ($(window).width() >= 768))
                return true;
            else
                return false;
        },

        isMd: function () {
            if (($(window).width() < 1200) && ($(window).width() >= 992))
                return true;
            else
                return false;
        },
        isLg: function () {
            if ($(window).width() >= 1200)
                return true;
            else
                return false;
        }
    },

    effects: {
        createApp: function (key, value) {
            var item = $('<div>').addClass('col-xs-12 col-sm-6 col-md-4 col-lg-5ths item');
            var application = $('<div>').addClass('application');

            if (value.img_tip) {
                var image = $('<div>').addClass('image').attr('style', "background-image : url('" + value.img_tip.replace('public','storage') + "');");
                image.appendTo(application);
            } else if (value.video_url) {
                if (value.video_type == 'youtube') {
                    var video = $('<div>').addClass('video youtube').attr('style', "background-image: url('" + value.video_image_id + "');");
                } else if (value.video_type == 'vimeo') {
                    var video = $('<div>').addClass('video vimeo').attr('style', "background-image: url('" + value.video_image_id + "');");
                }

                video.appendTo(application);
            }

            var a = $('<a>').attr('title', value.title).attr('href', '/zgloszenia/' + value.id);
            var c_table = $('<div>').addClass('c-table');
            var c_row = $('<div>').addClass('c-row');
            var c_cell = $('<div>').addClass('c-cell').text('zobacz');
            c_cell.appendTo(c_row);
            c_row.appendTo(c_table);
            c_table.appendTo(a);
            a.appendTo(application);

            var span = $('<span>').text(value.firstname + ' ' + value.lastname);
            span.appendTo(application);

            application.appendTo(item);
            item.appendTo("#applications .items");
        },

        hideLoader: function () {
            $('#loader').fadeOut();
        },

        matchMaxHeight: function () {
            $('#baner .steps .step').matchMaxHeight();
            $('#prizes .nty .nty-equal-height').matchMaxHeight();
            $('#take .step').matchMaxHeight();
            $('#products .item h4').matchMaxHeight();
            $('#products .item ul').matchMaxHeight();
        },

        setFullSizeSection: function (section) {
            section.css({
                'height': $(window).height() + 'px',
                'width': $(window).width() + 'px',
            });
        },

        popupContainerRow: function () {
            $('.popup-container-row').css({
                'height': $(window).height() - 40 + 'px'
            });
        },

        popupContainerRowCol: function () {
            $('.popup-container-row-col').matchMaxHeight();
        },

        e404: function () {
            if ($('section#e404').length) {
                $('section#e404').css({
                    'width': $(window).width() + 'px',
                    'height': $(window).height() + 'px',
                });
            }
        },

        set_center_vertical: function (items) {
            items.each(function () {
                var itm = $(this);

                itm.css({
                    "position": "absolute",
                });

                itm.css({
                    "top": '50%',
                    "margin-top": '-' + (itm.height() / 2) + 'px',
                });

            });
        },

        set_scroll_container_popup: function (obj) {
            obj.mCustomScrollbar({
                callbacks: {
                    onCreate: function () {
                        console.log("onCreate");
                    },
                    onInit: function () {
                        console.log("onInit");
                    }
                },
            });
        },

        disableScrolling: function () {
            const x = window.scrollX;
            const y = window.scrollY;
            window.onscroll = function () {
                window.scrollTo(x, y);
            };
        },

        enableScrolling: function () {
            window.onscroll = function () {

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
        for (var i = 0; i < items.length; i++) {
            max = max < $(items[i]).height() ?
                $(items[i]).height() : max;

        }
        $(items).css({'display': 'block', 'height': '' + max + 'px'});
    }
})(jQuery);

