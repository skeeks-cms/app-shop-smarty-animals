/*!
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 18.09.2015
 */
(function(sx, $, _)
{
    sx.classes.LightBox = sx.classes.Component.extend({

        _init: function()
        {},

        _onDomReady: function()
        {
            var _el = $(this.get('jsquerySelector'));

            if(_el.length > 0) {

                    if(typeof(jQuery.magnificPopup) == "undefined") {
                        return false;
                    }

                    jQuery.extend(true, jQuery.magnificPopup.defaults, {
                        tClose: 		'Close',
                        tLoading: 		'Loading...',

                        gallery: {
                            tPrev: 		'Previous',
                            tNext: 		'Next',
                            tCounter: 	'%curr% / %total%'
                        },

                        image: 	{
                            tError: 	'Image not loaded!'
                        },

                        ajax: 	{
                            tError: 	'Content not loaded!'
                        }
                    });

                    _el.each(function() {

                        var _t 			= jQuery(this),
                            options 	= _t.attr('data-plugin-options'),
                            config		= {},
                            defaults 	= {
                                type: 				'image',
                                fixedContentPos: 	false,
                                fixedBgPos: 		false,
                                mainClass: 			'mfp-no-margins mfp-with-zoom',
                                closeOnContentClick: true,
                                closeOnBgClick: 	true,
                                image: {
                                    verticalFit: 	true
                                },

                                zoom: {
                                    enabled: 		false,
                                    duration: 		300
                                },

                                gallery: {
                                    enabled: false,
                                    navigateByImgClick: true,
                                    preload: 			[0,1],
                                    arrowMarkup: 		'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
                                    tPrev: 				'Previous',
                                    tNext: 				'Next',
                                    tCounter: 			'<span class="mfp-counter">%curr% / %total%</span>'
                                },
                            };

                        if(_t.data("plugin-options")) {
                            config = jQuery.extend({}, defaults, options, _t.data("plugin-options"));
                        }

                        jQuery(this).magnificPopup(config);

                    });

            }

        },

        _onWindowReady: function()
        {}
    });
})(sx, sx.$, sx._);