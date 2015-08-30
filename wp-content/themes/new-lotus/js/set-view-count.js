/*
 * Set view count (post, page)
 * http://kopatheme.com
 * Copyright (c) 2014 Kopatheme
 *
 * Licensed under the GPL license:
 *  http://www.gnu.org/licenses/gpl.html
 */
jQuery(document).ready(function() {
    if (kopa_custom_front_localization.url.post_id > 0) {
        jQuery.ajax({
            type: 'POST',
            url: kopa_custom_front_localization.url.ajax,
            dataType: 'json',
            async: true,
            timeout: 5000,
            data: {
                action: 'kopa_set_view_count',
                wpnonce: jQuery('#kopa_set_view_count_wpnonce').val(),
                post_id: kopa_custom_front_localization.url.post_id
            },
            beforeSend: function(XMLHttpRequest, settings) {},
            complete: function(XMLHttpRequest, textStatus) {},
            success: function(data) {
                console.log(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
        });
    }
});