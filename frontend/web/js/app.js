/*!
 *
 * Skeeks cms application
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 15.10.2014
 * @since 1.0.0
 */
(function (sx, $, _) {
    sx.createNamespace('classes.App', sx);

    sx.classes.FancyboxContainer = sx.classes.Component.extend({

        construct: function (id, opts) {
            this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling
            this.set('id', id);
        },

        show: function () {
            $("<a>", {
                'href': "#" + this.get('id')
            })
                .text('sx-auto-fanxybox-btn')
                .fancybox(this.get('options', {}))
                .appendTo("body")
                .click();
        },

        _init: function () {
            console.log(this);
        },

        _onDomReady: function () {
            $('.sx-fancybox').fancybox();
        },

        _onWindowReady: function () {
        }
    });

    sx.classes.Fancybox = sx.classes.Component.extend({

        _onDomReady: function () {
            $('.sx-fancybox').fancybox();

            $("a.sx-fancybox-gallary", 'body').fancybox({
                //openEffect:'none',
                //closeEffect:'none',
                //prevEffect:'none',
                //nextEffect:'none',
                closeBtn: true,
                arrows: true,
                nextClick: true,
                padding: 5,
                helpers: {
                    title: {
                        type: 'inside'
                    },
                    thumbs: {
                        width: 100,
                        height: 100
                    }
                }
            });
        },

        close: function () {
            $.fancybox.close();
            return this;
        }
    });

    sx.classes.NotImplemented = sx.classes.Component.extend({

        _init: function () {
            this.onDomReady(function () {
                sx.notify.error('Еще не реилзованно', {
                    'life': '100000'
                });
                return false;
            });
        }
    });

    /**
     *
     */
    sx.classes.Pjax = sx.classes.Component.extend({

        _onDomReady: function () {
            var self = this;

            $(document).on('pjax:complete', function (e) {
                if (e.target.id == self.get('id')) {
                    new sx.classes.Location().href($(e.target));
                }
            });
        }
    });

    /**
     *
     */
    sx.classes.Location = sx.classes.Component.extend({

        href: function (id) {
            var duration = Number(this.get('duration', 500));
            var easing = String(this.get('easing', 'swing'));

            var Jtarget = $(id);
            var newHash = "#" + Jtarget.attr('id');

            if (!Jtarget.offset()) {
                return true;
            }

            var top = Jtarget.offset().top;
            var oldLocation = window.location.href.replace(window.location.hash, '');
            var newLocation = oldLocation + newHash;

            if (oldLocation + newHash == newLocation) {
                $('html:not(:animated),body:not(:animated)')
                    .animate({scrollTop: top - $("#topNav").height()}, duration, easing, function () {
                        /*window.location.href = newLocation;*/
                    });

                return true;
            }
        }
    });

    sx.classes.App = sx.classes.Component.extend({

        _init: function () {
            this.Fancybox = new sx.classes.Fancybox();
        },

        _onDomReady: function () {
            $(".sx-item-plus").popover({
                trigger: "hover",
                html: true,
                delay: {"show": 50, "hide": 1000}
            });

            this._initNotify();

            $('.sx-not-implemented').on('click', function () {
                sx.notify.info('Еще не реилзованно', {
                    'life': '10000'
                });
                return false;
            });

            $(document).on('pjax:complete', function (e) {
                $("img.sx-lazy").each(function () {
                    $(this).attr('src', $(this).data('original'));
                    $(this).removeAttr('data-original');
                });
            });

            $(".shop-item").hover(
                function () {
                    $('a.btn', $(this)).removeClass('btn-default').addClass('btn-primary');
                },
                function () {
                    $('a.btn', $(this)).removeClass('btn-primary').addClass('btn-default');
                }
            );

            _.delay(function () {
                $("img.sx-lazy").each(function () {
                    $(this).attr('src', $(this).data('original'));
                    $(this).removeAttr('data-original');
                });
            }, 200);
        },

        _initNotify: function () {
            //Глобальные настройки JGrowl
            $.jGrowl.defaults.closer = false;
            $.jGrowl.defaults.closeTemplate = '×';
            $.jGrowl.defaults.position = 'top-center';
            $.jGrowl.defaults.life = 5000;
        }
    });

    sx.App = new sx.classes.App();
})(sx, sx.$, sx._);

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});