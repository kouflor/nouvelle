/**
 * http://kopatheme.com
 * Copyright (c) 2014 Kopatheme
 *
 * Licensed under the GPL license:
 *  http://www.gnu.org/licenses/gpl.html
  **/
  
/**
 *
 *   1- Menu
 *   2- Video wrapper
 *   3- Map
 *   4- Carousel
 *   5- Search animate
 *   6- Tabs
 *   7- Slider
 *   8- Masonry
 *   9- Validate form
 *   10- Flickr
 *   11- Back to top
 *   12- Accordion & Toggle
 *   13- Sync carousel
 *   14- Browser resize
 *
 *-----------------------------------------------------------------
 **/
"use strict";
var map;
var kopa_variable = {
    "url": {
        "template_directory_uri": kopa_custom_front_localization.url.template_directory_uri
    }
};
jQuery(document).ready(function($) {

/**
 *
 *   1- Menu
 *
 *-----------------------------------------------------------------
 **/
Modernizr.load([{
    load: kopa_variable.url.template_directory_uri + 'js/superfish.js',
    complete: function() {
        $('.sf-menu.main-menu').superfish({
            delay: 400,
            speed: 'fast'
        });
    }
}]);
Modernizr.load([
  {
    load: kopa_variable.url.template_directory_uri + 'js/navgoco.js',
    complete: function () {
        $(".mobile-menu.main-menu").navgoco({accordion: true});

        $('.mobile-menu-icon').click(function(){
            $(".mobile-menu.main-menu").slideToggle( 300 );
        });
    }
  }
]);
/**
 *
 *   2- Video wrapper
 *
 *-----------------------------------------------------------------
 **/
if (jQuery(".video-wrapper").length > 0) {
    Modernizr.load([{
        load: kopa_variable.url.template_directory_uri + 'js/fitvids.js',
        complete: function() {
            $(".video-wrapper").fitVids();
        }
    }]);
};
/**
 *
 *   3- Map
 *
 *-----------------------------------------------------------------
 **/
if ($('.map-wrap').length > 0) {
    Modernizr.load([{
        load: kopa_variable.url.template_directory_uri + 'js/gmaps.js',
        complete: function() {
            var map_id = '#' + $('.map-wrap').attr('id');
            var lat = parseFloat($('.map-wrap').attr('data-latitude'));
            var lng = parseFloat($('.map-wrap').attr('data-longitude'));
            map = new GMaps({
                el: map_id,
                lat: lat,
                lng: lng,
                zoomControl: true,
                zoomControlOpt: {
                    style: 'SMALL',
                    position: 'TOP_LEFT'
                },
                panControl: false,
                streetViewControl: false,
                mapTypeControl: false,
                overviewMapControl: false
            });
            var marker_info = {
                lat: lat,
                lng: lng
            };
        }
    }]);
};
/**
 *
 *   4- Carousel
 *
 *-----------------------------------------------------------------
 **/

if (jQuery('.kopa-small-thumb-lightbox-carousel').length > 0) {
    Modernizr.load([{
        load: [kopa_variable.url.template_directory_uri + 'js/owl.carousel.js', kopa_variable.url.template_directory_uri + 'js/colorbox.js'],
        complete: function() {
            $(".kopa-small-thumb-lightbox-carousel .owl-carousel").owlCarousel({
                items: 3,
                itemsDesktop: [1200, 3],
                itemsDesktopSmall: [1023, 3],
                itemsTablet: [767, 3],
                itemsMobile: [480, 2],
                slideSpeed: 1000,
                navigation: true,
                navigationText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
                pagination: false
            });
            $(".group-colorbox").colorbox({
                rel: 'group-colorbox'
            });
        }
    }]);
}
if (jQuery('.owl-single-item').length > 0) {
    Modernizr.load([{
        load: kopa_variable.url.template_directory_uri + 'js/owl.carousel.js',
        complete: function() {
            $(".owl-single-item").owlCarousel({
                singleItem:true,
                slideSpeed: 1000
            });
        }
    }]);
}
var sync7 = $(".sync7");
var sync8 = $(".sync8");
if (sync7.length > 0) {
    Modernizr.load([{
        load: kopa_variable.url.template_directory_uri + 'js/owl.carousel.js',
        complete: function() {
            sync7.owlCarousel({
                singleItem: true,
                slideSpeed: 1000,
                afterAction: syncPosition4,
                responsiveRefreshRate: 200,
                autoHeight:true
            });
            sync8.owlCarousel({
                items: 4,
                itemsDesktop: [1199, 4],
                itemsDesktopSmall: [979, 4],
                itemsTablet: [768, 4],
                itemsMobile: [479, 4],
                pagination: false,
                responsiveRefreshRate: 100,
                afterInit: function(el) {
                    el.find(".owl-item").eq(0).addClass("synced");
                }
            });
        }
    }]);
};

function syncPosition4(el) {
    var current = this.currentItem;
    $(".sync8").find(".owl-item").removeClass("synced").eq(current).addClass("synced")
    if ($(".sync8").data("owlCarousel") !== undefined) {
        center4(current)
    }
}

function center4(number) {
    var sync8visible = sync8.data("owlCarousel").owl.visibleItems;
    var num = number;
    var found = false;
    for (var i in sync8visible) {
        if (num === sync8visible[i]) {
            var found = true;
        }
    }
    if (found === false) {
        if (num > sync8visible[sync8visible.length - 1]) {
            sync8.trigger("owl.goTo", num - sync8visible.length + 2)
        } else {
            if (num - 1 === -1) {
                num = 0;
            }
            sync8.trigger("owl.goTo", num);
        }
    } else if (num === sync8visible[sync8visible.length - 1]) {
        sync8.trigger("owl.goTo", sync8visible[1])
    } else if (num === sync8visible[0]) {
        sync8.trigger("owl.goTo", num - 1)
    }
}
$(".sync8").on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = $(this).data("owlItem");
    sync7.trigger("owl.goTo", number);
});
/**
 *
 *   5- Search animate
 *
 *-----------------------------------------------------------------
 **/
if ($('#kopa-search').length > 0) {
    Modernizr.load([{
        load: [kopa_variable.url.template_directory_uri + 'js/uisearch.js', kopa_variable.url.template_directory_uri + 'js/classie.js'],
        complete: function() {
            new UISearch(document.getElementById('kopa-search'));
        }
    }]);
};
/**
 *
 *   6- Tabs
 *
 *-----------------------------------------------------------------
 **/
if ($('.nav-tabs').length > 0) {
    Modernizr.load([{
        load: kopa_variable.url.template_directory_uri + 'js/bootstrap.js',
        complete: function() {
            $('.nav-tabs a').click(function(e) {
                e.preventDefault()
                $(this).tab('show')
            })
        }
    }]);
};

/**
 *
 *   9- Validate form
 *
 *-----------------------------------------------------------------
 **/

if ($('.contact-form').length > 0) {
    Modernizr.load([{
        load: [kopa_variable.url.template_directory_uri + 'js/form.js', kopa_variable.url.template_directory_uri + 'js/validate.min.js'],
        complete: function() {
            jQuery('.contact-form').validate({
                // Add requirements to each of the fields
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 10
                    }
                },
                // Specify what error messages to display
                // when the user does something horrid
                messages: {
                    name: {
                        required: kopa_variable.validate.name.required,
                        minlength: jQuery.format(kopa_variable.validate.name.minlength)
                    },
                    email: {
                        required: kopa_variable.validate.email.required,
                        email: kopa_variable.validate.email.EMAIL
                    },
                    message: {
                        required: kopa_variable.validate.message.required,
                        minlength: jQuery.format(kopa_variable.validate.message.minlength)
                    }
                },
                // Use Ajax to send everything to processForm.php
                submitHandler: function(form) {
                    jQuery(".contact-form.input-submit").attr("value", kopa_variable.validate.form.sending);
                    jQuery(form).ajaxSubmit({
                        success: function(responseText, statusText, xhr, $form) {
                            jQuery("#response").html(responseText).hide().slideDown("fast");
                            jQuery(".contact-form.input-submit").attr("value", kopa_variable.validate.form.submit);
                        }
                    });
                    return false;
                }
            });
        }
    }]);
}

/**
 *
 *   10- Flickr
 *
 *-----------------------------------------------------------------
 **/
if (jQuery('.kopa-flickr-widget').length > 0) {
    Modernizr.load([{
        load: [kopa_custom_front_localization.url.template_directory_uri + '/js/jflickrfeed.js',
            kopa_custom_front_localization.url.template_directory_uri + '/js/imgliquid.js'
        ],
        complete: function() {
            jQuery('.flickr-wrap ul').each(function() {
                var $this = jQuery(this),
                    flickrID = $this.parent().data('user'),
                    limit = $this.parent().data('limit');

                $this.jflickrfeed({
                    limit: limit,
                    qstrings: {
                        id: flickrID
                    },
                    itemTemplate: '<li class="flickr-badge-image">' + '<a target="blank" href="{{link}}" title="{{title}}" class="imgLiquid">' + '<img src="{{image_m}}" alt="{{title}}"  />' + '</a>' + '</li>'
                }, function(data) {
                    jQuery('.kopa-flickr-widget .imgLiquid').imgLiquid();
                });
            });
        }
    }]);
}
/**
 *
 *   11- Back to top
 *
 *-----------------------------------------------------------------
 **/
jQuery(".back-to-top").hide();
jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 100) {
        jQuery('.back-to-top').fadeIn();
    } else {
        jQuery('.back-to-top').fadeOut();
    }
});
jQuery('.back-to-top').click(function(event) {
    jQuery('body,html').animate({
        scrollTop: 0
    }, 800);
    event.preventDefault();
});
/**
 *
 *   12- Accordion & Toggle
 *
 *-----------------------------------------------------------------
 **/
if ($('.kopa-accordion').length > 0) {
    Modernizr.load([{
        load: kopa_variable.url.template_directory_uri + 'js/bootstrap.js',
        complete: function() {}
    }]);
};
if ($('.kopa-toggle').length > 0) {
    $('.kopa-toggle .panel-heading').click(function() {
        $(this).find('.panel-title span').toggleClass('collapsed');
        var panel_content = $(this).parent().find('.panel-collapse');
        if (panel_content.is(':hidden')) {
            $(this).addClass('in');
            panel_content.slideDown('350');
        } else {
            $(this).removeClass('in');
            panel_content.slideUp('350');
        }
    });
};



});


/**
 *
 *   14- Browser resize
 *
 *-----------------------------------------------------------------
 **/
Modernizr.load([{
    load: kopa_variable.url.template_directory_uri + 'js/debouncedresize.js',
    complete: function() {
        jQuery(window).bind("debouncedresize", function() {
            if (jQuery(window).outerWidth()>980) {
                jQuery(".mobile-menu.main-menu").css('display','none');
            };
        });
    }
}]);