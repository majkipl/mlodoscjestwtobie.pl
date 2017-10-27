let event;
let height;

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

const starter = {
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

            starter._var.filter["phrase"] = '';
            starter._var.filter["order"] = 0;
            starter._var.filter["sort"] = 1;
            starter._var.filter["limit"] = 10;
            starter._var.filter["offset"] = 0;

            starter.datepicker.init();
            starter.listTipsRender.init();
        },


        onClick: function () {
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

            $(document).on('click', '#contact a.send', function () {
                $(this).closest('form').submit();
                return false;
            });

            $(document).on('click', 'a.popup-open', function () {
                let popup = $('section#popup_' + $(this).data('popup'));

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
                let popup = $(this).parents('section');

                popup.removeClass('popup-show').fadeOut();

                starter.effects.enableScrolling();

                return false;
            });

            $(document).on('click', '.menu-container ul li a', function () {
                let attri = $(this).data('href');

                if ($(attri).length > 0) {
                    event.preventDefault();
                    history.pushState(null, null, $(this).attr("href"));

                    let offset = Math.abs($(attri).position().top);
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
                            }
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
                        default:
                            return true;
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
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });

                return false;
            });

            $(document).on('submit', '#form form', function () {
                $('.input, .textarea, .checkbox, .file').trigger('change');

                if (Object.keys(starter._var.error).length === 0) {
                    const fields = starter.getFields($(this).closest('form'));
                    const url = $(this).closest('form').attr('action');
                    const formData = new FormData();

                    for (const field in fields) {
                        formData.append(field, fields[field]);
                    }

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
                            console.log(error.request);
                        } else {
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
            $(document).on('keyup', '#applications input#find', function () {
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

                const file = $('input#img_tip');

                if (file[0].files[0]) {
                    if( value === "" ) {
                        return true;
                    } else {
                        return `Twoje zgłoszenie może zawierać tekst ze zdjęciem lub tekst z video.`;
                    }
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
                const videoUrl = $('#video_url');

                if (videoUrl.val() === "" && file[0].files.length === 0) {
                    return `Pole ${name} jest wymagane.`;
                } else if (videoUrl.val() !== "" && file[0].files.length !== 0) {
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

        scroll: function () {

        },

        selectbox: function () {
            const selectElement = $("#form select");

            if (selectElement.length > 0) {
                selectElement.selectbox({
                    onOpen: function (inst) {
                        $('select#where option').removeAttr('selected');
                        $('#sbHolder_' + inst.uid).addClass('focus');
                    },
                    onClose: function (inst) {
                        $('#sbHolder_' + inst.uid).removeClass('focus');
                    },
                    onChange: function (val, inst) {
                        if (inst.id === 'category') {
                            if (val > 0) {
                                axios.get('/api/product/category/' + val)
                                    .then(function (response) {
                                        $('select#product option').remove();

                                        let option = $('<option>').attr('label', 'Produkt').text('Produkt');
                                        option.appendTo("select#product");

                                        response.data.rows.forEach(function (value) {
                                            let option = $('<option>').attr('label', value.name).attr('value', value.id).text(value.name);
                                            option.appendTo("select#product");
                                        });

                                        const selectProduct = $("select#product");

                                        selectProduct.selectbox("detach");

                                        starter.main.selectbox(selectProduct);
                                        $(`.error-category`).text('');
                                    })
                                    .catch(function (error) {
                                        console.log('axios error:', error);
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
                    console.log(error.request);
                } else {
                    console.log('Error', error.message);
                }
            });
        },

        owl: function () {
            const owlCarouselElement = $(".owl-carousel");

            if (owlCarouselElement.length > 0) {
                starter._var.owl_products = owlCarouselElement.owlCarousel({
                    loop: true,
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
            const pathToSelector = {
                '/': '#baner',
                '/nagrody': '#prizes',
                '/wez-udzial': '#take',
                '/zgloszenia': '#applications',
                '/zgloszenia-tygodnia': '#week',
                '/nasze-produkty': '#products',
                '/kontakt': '#contact'
            };

            let attri = pathToSelector[window.location.pathname];

            if (attri && $(attri).length) {
                $('html, body').animate({scrollTop: $(attri).position().top}, 1000);
            }
        },

        menu_light_section: function (section) {
            const height = $(window).scrollTop() + $(window).height() / 2;

            let pathname;

            if ($(section).length > 0) {
                if (height > $(section).position().top && height < $(section).position().top + $(section).height()) {
                    const menuContainer = $('.menu-container ul li a[data-href="' + section + '"]');

                    if (menuContainer.length > 0) {
                        const ob = menuContainer;
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
            const bgVideo = $('#bgvid');

            if (bgVideo.length) {
                const ww = $(window).width();
                const wh = $(window).height();

                const rw = ww / wh;
                const rv = 1920 / 1080;

                if (rw > rv) { //landscape
                    bgVideo.css({
                        'width': ww + 'px',
                        'height': (ww * 1080 / 1920) + 'px',
                        'margin-top': '-' + (ww * 1080 / 1920 / 2) + 'px',
                        'margin-left': '-' + (ww / 2) + 'px',
                    });
                } else { //portrait
                    bgVideo.css({
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
            }
        }
    },

    rwd: {
        isXs: function () {
            return $(window).width() < 768;
        },

        isSm: function () {
            return ($(window).width() < 992) && ($(window).width() >= 768);
        },

        isMd: function () {
            return ($(window).width() < 1200) && ($(window).width() >= 992);
        },
        isLg: function () {
            return $(window).width() >= 1200;
        }
    },

    effects: {
        createApp: function (key, value) {
            let item = $('<div>').addClass('col-xs-12 col-sm-6 col-md-4 col-lg-5ths item');
            let application = $('<div>').addClass('application');

            if (value.img_tip) {
                let image = $('<div>').addClass('image').attr('style', "background-image : url('" + value.img_tip.replace('public', 'storage') + "');");
                image.appendTo(application);
            } else if (value.video_url) {
                let video = $('<div>').addClass('video').attr('style', "background-image: url('" + value.video_image_id + "');");

                if (value.video_type === 'youtube') {
                    video.addClass('youtube');
                } else if (value.video_type === 'vimeo') {
                    video.addClass('vimeo');
                }

                video.appendTo(application);
            }

            const a = $('<a>').attr('title', value.title).attr('href', '/zgloszenia/' + value.id);
            const c_table = $('<div>').addClass('c-table');
            const c_row = $('<div>').addClass('c-row');
            const c_cell = $('<div>').addClass('c-cell').text('zobacz');
            c_cell.appendTo(c_row);
            c_row.appendTo(c_table);
            c_table.appendTo(a);
            a.appendTo(application);

            const span = $('<span>').text(value.firstname + ' ' + value.lastname);
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
            const error404 = $('section#e404');

            if (error404.length) {
                error404.css({
                    'width': $(window).width() + 'px',
                    'height': $(window).height() + 'px',
                });
            }
        },

        set_center_vertical: function (items) {
            items.each(function () {
                const itm = $(this);

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
        const items = $(this);
        $(items).attr('style', '');
        $(items).css({});
        let max = 0;
        for (let i = 0; i < items.length; i++) {
            max = max < $(items[i]).height() ?
                $(items[i]).height() : max;

        }
        $(items).css({'display': 'block', 'height': '' + max + 'px'});
    }
})(jQuery);
