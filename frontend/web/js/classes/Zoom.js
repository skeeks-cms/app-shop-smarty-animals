/*!
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 18.09.2015
 */
(function(sx, $, _)
{
    sx.classes.Zoom = sx.classes.Component.extend({

        _init: function()
        {},

        _onDomReady: function()
        {
            $(this.get('jsquerySelector')).each(function() {
                var _t 		= jQuery(this),
                    _mode 	= _t.attr('data-mode'),
                    _id		= _t.attr('id');

                if(_mode == 'grab') {
                    _t.zoom({ on:'grab' });
                } else

                if(_mode == 'click') {
                    _t.zoom({ on:'click' });
                } else

                if(_mode == 'toggle') {
                    _t.zoom({ on:'toggle' });
                } else {
                    _t.zoom();
                }


                // Thumbnails
                if(_id) {
                    jQuery('.zoom-more[data-for='+_id+'] a').bind("click", function(e) {
                        e.preventDefault();

                        var _href = jQuery(this).attr('href');

                        if(_href != "#") {
                            jQuery('.zoom-more[data-for='+_id+'] a').removeClass('active');
                            jQuery(this).addClass('active');

                            jQuery('figure#'+_id + '>.lightbox').attr('href', _href);

                            /*jQuery('figure#'+_id + '>img').fadeOut(0, function() {
                                jQuery('figure#'+_id + '>img').attr('src', _href);
                            }).fadeIn(500);*/

                            jQuery('figure#'+_id + '>img').attr('src', _href);
                        }
                    });
                }

            });
        },

        _onWindowReady: function()
        {}
    });
})(sx, sx.$, sx._);