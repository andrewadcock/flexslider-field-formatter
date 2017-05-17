/**
 * @file
 * Placeholder file for custom sub-theme behaviors.
 *
 */
(function ($, Drupal) {

    /**
     * Use this behavior as a template for custom Javascript.
     */
    Drupal.behaviors.initFlexSlider = {
        attach: function (context, settings) {

            $(context).find('.flexslider-thumbnails').each(function () {

                if(true == settings.flexslider_field_formatter['0'].show_carousel) {
                    $(window).load(function () {
                        $('.flexslider-thumbnails').flexslider({
                            animation: "slide",
                            controlNav: false,
                            animationLoop: true,
                            slideshow: false,
                            itemWidth: parseInt(settings.flexslider_field_formatter['0'].itemWidth),
                            itemMargin: 5,
                            asNavFor: '.flexslider-slider'
                        });
                    });
                }
            });

            $(context).find('.flexslider-slider').each(function () {

                if(true == settings.flexslider_field_formatter['0'].show_carousel) {
                    $(window).load(function () {
                        $('.flexslider-slider').flexslider({
                            animation: "slide",
                            controlNav: false,
                            animationLoop: true,
                            slideshow: false,
                            sync: ".flexslider-thumbnails"
                        });
                    });
                } else {
                    $(window).load(function () {
                        $('.flexslider-slider').flexslider({
                            animation: "slide",
                            controlNav: true,
                            animationLoop: true,
                            slideshow: false
                        });
                    });
                }
            });
        }
    };

})(jQuery, Drupal);
