+function ($)
{
    "use strict";

    $(document).off('click').on('click', '[class*="hideshow"]', function (e)
    {
        console.log('here', e.target.id, $(this).parent().parent());
        var type ='password';
        var idShow = 'fa-eye';
        var idHide = 'fa-eye-slash';
        if ($('#password').attr('type')=='password')
        {
            type ='text';
            idShow = 'fa-eye-slash';
            idHide = 'fa-eye';
        }

        $('#password').attr('type', type);
        $(this).parent().parent().find('#' + idShow).css('display', 'block');
        $(this).parent().parent().find('#' + idHide).css('display', 'none');
    });

    $(document).off('click').on('click', '[class*="hideshownew"]', function (e)
    {
        var type = "password" ;
        var idParent = '#'+e.target.id;
        var dataIdParent = $(idParent).attr('dataIdParent');
        var idShow = $(idParent).attr('dataIdShow');
        var idHide = $(idParent).attr('dataIdHide');
        console.log('here',idParent, $('#'+dataIdParent).attr('type'));
        if ($('#'+dataIdParent).attr('type')=='password')
        {
            type ='text';
            $('#' + idHide).css('display', 'block');
            $('#' + idShow).css('display', 'none');

        }
        else
        {
            type ='password';
            $('#' + idShow).css('display', 'block');
            $('#' + idHide).css('display', 'none');
        }

        $('#' + dataIdParent).attr('type', type);
        //$('#' + idShow).css('display', 'block');

    });

    String.prototype.replaceArray = function(find, replace) {
        var replaceString = this;
        var regex;
        for (var i = 0; i < find.length; i++) {
            regex = new RegExp(find[i], "g");
            replaceString = replaceString.replace(regex, replace[i]);
        }
        return replaceString;
    };


    $(function()
    {
        /*--
            serialize form to send data json
        -----------------------------------*/
        $.fn.serializeObject = function()
        {
            var o = {};
            var a = this.serializeArray();

            $.each(a, function()
            {
                if (o[this.name])
                {
                    if (!o[this.name].push)
                    {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                }
                else
                {
                    o[this.name] = this.value || '';
                }
            });


            console.log('have file in form', this.find(':file').val());
            if (this.find(':file').val())
            {
                var fichier = document.getElementById(this.find(':file').attr('id'));
                var fileReader = new FileReader();
                fileReader.onload = function() {
                    o['file'] = fileReader.result;
                };
                fileReader.readAsDataURL(fichier.files[0]);
            }
            // o['fichier'] = "successfull";

            return o;
        };


        $.fn.validate = function()
        {
            var prefixeForm = $(this).attr('id').substr(8, $(this).attr('id').length-1);

            var o = {};
            var a = this.serializeArray();
            console.log('form',  a);

            var is_validate = true;
            $.each(a, function()
            {
                var itemValue = this.name + '_' + prefixeForm;
                var itemId = '#' + itemValue;
                var displayField;
                try
                {
                    displayField = $('[for="'+ itemValue +'"]').html() ? $('[for="'+ itemValue +'"]').html() : $(itemId).attr('placeholder') ? $(itemId).attr('placeholder') : this.name;
                }
                catch(err)
                {
                    displayField = $('[for="'+ itemValue +'"]').html() ? $('[for="'+ itemValue +'"]').html() : this.name;
                }

                try
                {
                    $(itemId).removeClass('border-danger');
                    if ($(itemId).hasClass('required') && !this.value)
                    {
                        $(itemId).addClass('border-danger');
                        iziToast.error({
                            title: "",
                            message: "Renseignez le champ <span class=\"fw-bold text-capitalize\">" + displayField + "</span>",
                            position: 'topRight'
                        });
                        is_validate = false;
                    }
                }
                catch (e)
                {
                    console.log('validate =', e);
                }

                return is_validate;
            });


            if (is_validate)
                $.each(this.find('[id^="fichier_"]'), function () {
                    var itemValue = this.name + '_' + prefixeForm;
                    console.log(itemValue);
                    var itemId = '#' + itemValue;
                    var displayField = $('[for="'+ itemValue +'"]').html() ? $('[for="'+ itemValue +'"]').html() : this.name;
                    $(itemId).removeClass('border-danger');
                    if ($(itemId).hasClass('required') && !this.value)
                    {
                        $(itemId).addClass('border-danger');
                        iziToast.error({
                            title: "",
                            message: "Choisir un fichier pour le champ <span class=\"fw-bold\">" + displayField + "</span>",
                            position: 'topRight'
                        });
                        is_validate = false;
                    }
                    return is_validate;
                });

            return is_validate;
        };




        /*--
                class
        -----------------------------------*/
        $(document).on('click', '[data-toggle^="class"]', function (e)
        {
            e && e.preventDefault();
            var $this = $(e.target), $class, $target, $tmp, $classes, $targets;
            !$this.data('toggle') && ($this = $this.closest('[data-toggle^="class"]'));
            $class = $this.data()['toggle'];
            $target = $this.data('target') || $this.attr('href');
            $class && ($tmp = $class.split(':')[1]) && ($classes = $tmp.split(','));
            $target && ($targets = $target.split(','));
            $classes && $classes.length && $.each($targets, function (index, value) {

                //$($targets[index]).toggleClass($classes[index]);
                //TODO: A retirer
                console.log('**********************', $($targets[index]), $classes[index]);

                if ($classes[index].indexOf('*') !== -1)
                {
                    var patt = new RegExp('\\s' +
                        $classes[index].replace(/\*/g, '[A-Za-z0-9-_]+').split(' ').join('\\s|\\s') +
                        '\\s', 'g');
                    $($this).each(function (i, it) {
                        var cn = ' ' + it.className + ' ';
                        while (patt.test(cn)) {
                            cn = cn.replace(patt, ' ');
                        }
                        it.className = $.trim(cn);
                    });
                }
                if ($targets[index] != '#')
                {
                    $($targets[index]).toggleClass($classes[index]);
                }
                else $this.toggleClass($classes[index]);
            });
            $this.toggleClass('active');
        });


        $(document).ready(function()
        {
            // Pour rebuild l'ensemble des modals
            // $(".modal[role=dialog]").modal('hide');

            $(".active1 a").click(function()
            {
                $(".active1 a").removeClass("uk-active");
                $(this).addClass("uk-active");
            });
        });


        /*--
                blockUI
        -----------------------------------*/
        $.fn.blockUI_start = function ()
        {
            $(this).block({
                message: '<i class="fa fa-lg fa-spinner fa-spin"></i>' ,
                css: {
                    border: 'none',
                    backgroundColor: 'transparent',
                    color: '#fff',
                    padding: '30px',
                    width: '100%'
                },
                overlayCSS:  {
                    backgroundColor:	'#000',
                    opacity:			0.5
                }
            });
        };

        $.fn.blockUI_stop = function ()
        {
            $(this).unblock();
        };


        /*--
            QrCode
        -----------------------------------*/
        $.qrCodeReader.jsQRpath = "assets/js/jsQR.min.js";
        $.qrCodeReader.beepPath = "assets/audio/beep.mp3";
        $.qrCodeReader.height = 480;
        $.qrCodeReader.width = 640;

        // bind all elements of a given class
        $(".qrcode-reader").qrCodeReader();


        /*--
            Add Rules to the theme
        -----------------------------------*/
        $('body')
            .on('dblclick', '#kt_wrapper' , function(e) {
                if (!KTToggle.getInstance(document.querySelector('#kt_aside_toggle')).isEnabled())
                {
                    KTToggle.getInstance(document.querySelector('#kt_aside_toggle')).enable();
                }
            })
            .on('click', '.aside-nav.nav > li.nav-item, .aside-logo', function(e)
            {
                // kt_aside_wordspace reduire le menu open
                var tabContent = $('#kt_aside_wordspace .tab-content');
                tabContent.each(function() {
                    var tabPanes = $(this).find('.tab-pane');
                    console.log("ici papa tab-content", tabPanes)
                    tabPanes.each(function() {
                        $(this).removeClass("active show")
                    });
                });

                $('.aside-nav').find('.nav > li.nav-item > a[class*=" active"][target][href!="' +  $(this).find('a').attr('href') + '"]').removeClass('active');

                // Permet de retirer active show dans la barre qui s'ouvre
                $('.aside-workspace  > tab-pane[id!="' +  $(this).find('a').attr('href').substr(1, $(this).find('a').attr('href').length) + '"]').removeClass('active show');

                var lengthVar = $(this).find('a[ng-href]').length > 0 ? 0 : $($(this).find('a').attr('href')).length;

                if ((KTToggle.getInstance(document.querySelector('#kt_aside_toggle')).isEnabled() && lengthVar> 0) || (!KTToggle.getInstance(document.querySelector('#kt_aside_toggle')).isEnabled() && lengthVar==0))
                {
                    KTToggle.getInstance(document.querySelector('#kt_aside_toggle')).toggle();
                }
            })
            .on('click', '#kt_aside_toggle, #kt_aside_nav', function(e)
            {
                // aside-minimize
                var bodyElement = $('body');
                if (bodyElement.attr('data-kt-aside-minimize')) {
                    bodyElement.removeClass('aside-minimize');
                    console.log('HideMenu');
                } else {
                    console.log('openMenu');
                    bodyElement.addClass('aside-minimize');
                }

                // kt_aside_wordspace reduire le menu open
                var tabContent = $('#kt_aside_wordspace .tab-content');
                tabContent.each(function() {
                    // Sélectionner tous les éléments avec la classe "tab-pane"
                    var tabPanes = $('.tab-pane');

                });
                
                console.log("Menu");
            });

            window.dispatchEvent(new Event('resize'));
    });


    // remove aside menu content 1 item
    const menutabs = Array.from(document.querySelectorAll('#kt_aside li.nav-item a'))
    const enableMenuTab = (tab)=>{
        if(tab==null){
            menutabs.map(
                tab=>{
                    if(tab.getAttribute('ng-href') == document.location.hash){
                        enableMenuTab(tab)
                    }
                }
            )
        }
    }

    menutabs.map(
        tab=>{
            tab.addEventListener('click' ,e=>{
                    if(!tab.href.match('kt_aside'))
                    {
                        document.body.setAttribute('data-kt-aside-minimize','on');
                    }
                    else
                    {
                        document.querySelectorAll('.aside-secondary .tab-pane').forEach(tabpane => {
                                if(!tab.href.match(tabpane.id))
                                {
                                    tabpane.classList.remove('active')
                                    tabpane.classList.remove('show')
                                }
                            }
                        )
                    }
                    enableMenuTab(tab);
                }
            )
        }
    )
    enableMenuTab();

}(window.jQuery);
