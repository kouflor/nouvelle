<?php

add_action( 'after_setup_theme', 'kopa_front_after_setup_theme' );

function kopa_front_after_setup_theme() {
    add_theme_support( 'post-formats', array( 'gallery', 'audio', 'video', 'link', 'quote' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support('loop-pagination');


    register_nav_menus(array(
        'top-nav'      => __( 'Top_Menu', 'new-lotus' ),
        'main-nav'     => __( 'Main Menu', 'new-lotus' ),
    ));

    global $content_width;
    if ( ! isset( $content_width ) ) {
        $content_width = 911;
    }

    if (!is_admin()) {
        add_filter('wp_title', 'kopa_wp_title', 10, 2);
        add_action('wp_enqueue_scripts', 'kopa_enqueue_script');
        add_action('wp_footer', 'kopa_footer');
        add_action('wp_head', 'kopa_head');
    }
}

/**
 * @package Kopa
 * @subpackage Lotus
 * @author: kopatheme
 * @description: Load stylesheet, javascript file and localization variables
 */
function kopa_enqueue_script() {
    if ( ! is_admin() ) {
        global $wp_styles, $wp_version;
        $dir = get_template_directory_uri();


        // custom body class
        add_filter('body_class', 'kopa_body_class');

        // theme options - custom font


        // load css files
        wp_enqueue_style('kopa-Roboto-Condensed', '//fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700');
        wp_enqueue_style('kopa-font-awesome', $dir . '/css/font-awesome.css');
        wp_enqueue_style('kopa-style', get_stylesheet_uri());
        wp_enqueue_style('kopa-extra', $dir . '/css/extra.css');

        // load js files
        wp_enqueue_script('modernizr.custom', $dir . '/js/modernizr.custom.min.js', array('jquery'), null);
        wp_enqueue_script('set-view-count-js', $dir . '/js/set-view-count.js', array('jquery'), null, true);
        wp_enqueue_script('kopa-custom-js', $dir . '/js/custom.js', array('jquery'), null, true);

        // send localization to frontend
        wp_localize_script('kopa-custom-js', 'kopa_custom_front_localization', kopa_custom_front_localization());

        if (is_single() || is_page()) {
            wp_enqueue_script('comment-reply');
        }
    }
}

function kopa_head() {
    // contains all theme options custom styles
    $custom_styles = '';

    /* Logo */
    $logo_margin_top = kopa_get_option('logo_margin_top');
    $logo_margin_left = kopa_get_option('logo_margin_left');

    $logo_margin = '';
    if ( $logo_margin_top ) {
        $logo_margin .= "margin-top:{$logo_margin_top}px;";
    }
    if ( $logo_margin_left ) {
        $logo_margin .= "margin-left:{$logo_margin_left}px;";
    }
    if ( $logo_margin ) {
        $custom_styles .= "#kopa-logo { $logo_margin }";
    }
    
    /* ==================================================================================================
     * Theme Options custom styles
     * ================================================================================================= */
    echo '<style id="kopa-theme-options-custom-styles">'.$custom_styles.'</style>';

    /* ==================================================================================================
     * Custom Css
     * ================================================================================================= */
    $kopa_theme_option_custom_css = kopa_get_option('custom_css');
    if ( !empty($kopa_theme_option_custom_css) ) {
        $kopa_theme_option_custom_css = htmlspecialchars_decode(stripslashes($kopa_theme_option_custom_css));
        echo "<style id='kopa-user-custom-css' type='text/css'>{$kopa_theme_option_custom_css}</style>";
    }
}
/**
 * @package Kopa
 * @subpackage Lotus
 * @author: kopatheme
 * @description: Pass localization variables to js
 */

function kopa_custom_front_localization() {
    $front_localization = array(
        'url' => array(
            'template_directory_uri' => get_template_directory_uri().'/',
            'ajax' => admin_url('admin-ajax.php'),
            'post_id' => (is_singular()) ? get_queried_object_id() : 0
        ),
        'validate' => array(
            'name' => array(
                'required' => __('Please enter your name.', 'new-lotus'),
                'minlength' => __('At least {0} characters required.', 'new-lotus')
            ),
            'email' => array(
                'required' => __('Please enter your email...', 'new-lotus'),
                'email' => __('Please enter a valid email.', 'new-lotus')
            ),
            'phone' => array(
                'required' => __('Please enter your phone.','new-lotus'),
                'phone' => __('Please enter a valid phone number','new-lotus')
            ),
            'url' => array(
                'required' => __('Please enter your url.', 'new-lotus'),
                'url' => __('Please enter a valid url.', 'new-lotus')
            ),
            'message' => array(
                'required' => __('Please enter a message.', 'new-lotus'),
                'minlength' => __('At least {0} characters required.', 'new-lotus')
            ),
            'form' => array(
                'sending'=> __('Sending...', 'new-lotus'),
                'submit'=> __('Submit', 'new-lotus')
            )

        ),

        'navigation' => array(
            'prev' => __('Prev','new-lotus'),
            'next' => __('Next','new-lotus')
        )
    );

    return $front_localization;
}

/**
 * @package Kopa
 * @subpackage Lotus
 * @author: kopatheme
 * @description: get custom body class
 */
function kopa_body_class($classes) {
    $kopa_setting = kopa_get_template_setting();
    
    if ( is_category() ) {
        if ( 'blog_fullwidth' === $kopa_setting['layout_id'] ) {
            $classes[] = 'no-sidebar';
        }
    }
    if ( is_single() ) {
        if ( 'single_fullwidth' === $kopa_setting['layout_id'] ) {
            $classes[] = 'no-sidebar';
        }
    }
    if ( is_page() ) {
        if ( 'page_fullwidth' === $kopa_setting['layout_id'] ) {
            $classes[] = 'no-sidebar';
        }
    }
    if ( is_404() ) {
        if ( 'page_404_fullwidth' === $kopa_setting['layout_id'] ) {
            $classes[] = 'no-sidebar';
        }
    }
     

    return $classes;
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @package Kopa
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function kopa_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() ) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ) {
        $title = "$title $sep " . sprintf( __( 'Page %s', 'new-lotus' ), max( $paged, $page ) );
    }

    return $title;
}


/**
 * @package Kopa
 * @subpackage Lotus
 * @author: kopatheme
 * @description: Print current time
 */
function kopa_the_current_time(){
    $retdate = '';
    $rettime = '';
    $current_timestamp = current_time('timestamp');

    $retdate .= date_i18n( get_option( 'date_format' ), $current_timestamp);
    $rettime .= date_i18n( get_option( 'time_format' ), $current_timestamp);
    
    echo $retdate.' | '.$rettime;
}

/**
 * @package Kopa
 * @subpackage Lotus
 * @author: kopatheme
 * @description: print socials in header
 */

/*
 * Kopa get image source
 */
function kopa_get_image_src($pid = 0, $size = 'full') {
    $thumb = get_the_post_thumbnail($pid, $size);
    if (!empty($thumb)) {
        $_thumb = array();
        $regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
        preg_match($regex, $thumb, $_thumb);
        $thumb = $_thumb[2];
    }
    return $thumb;
}
function kopa_get_image_by_id($img_id, $size='full'){
    $thumb = wp_get_attachment_image($img_id,$size);
    if (!empty($thumb)) {
        $_thumb = array();
        $regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
        preg_match($regex, $thumb, $_thumb);
        $thumb = $_thumb[2];
    }
    return $thumb;
}

/*
 * Kopa print image use bfithumb
 */

function kopa_the_image($pid=0,$alt='',$width=0,$height=0,$crop=true, $get_by_img_id = false){
    $key_name = 'thumbnail_'.$width.'x'.$height;
    $custom_thumbnail = get_post_meta( $pid, $key_name, true );
    if(!empty($custom_thumbnail)){
        echo '<img src="' . $custom_thumbnail . '" alt="' . $alt . '" />';
    }else if(false == $get_by_img_id){
        $img_src = kopa_get_image_src($pid);
        $params = array('width' => $width, 'height' => $height, 'crop' => $crop);
        return '<img src="'. bfi_thumb($img_src,$params) .'" alt="'.$alt.'">';
    } else {
        $img_src = kopa_get_image_by_id($pid);
        $params = array('width' => $width, 'height' => $height, 'crop' => $crop);
        return '<img src="'. bfi_thumb($img_src,$params) .'" alt="'.$alt.'">';
    } 
    
}


function kopa_the_date_custom ($post_id = 0, $format = 'Y') {
    $date = date_create(get_post_field( 'post_date', $post_id));
    return $date->format($format);
}

/**
 * @package Kopa
 * @subpackage Lotus
 * @author: kopatheme
 * @description: get custom excerpt by word
 */
function kopa_get_the_excerpt_for_widget($excerpt='', $content = '', $length = 0) {
    if ( $length != 0 ){
        $kopa_length = $length;
    }elseif(is_category() || is_tag() || is_home()) {
        $kopa_length = (int) kopa_get_option('excerpt_blog');
    }else{
        $kopa_length = (int) kopa_get_option('excerpt_front_page');
    }
    global $post;
    if(empty($excerpt)){
        $temp_excerp = $post->post_excerpt;
    }else{
        $temp_excerp = $excerpt;
    }

    if ( empty($temp_excerp) ) {
        if(empty($content)){
            global $more;
            $temp = $more;
            $more = false;
            $content = get_the_content('');
            $more = $temp;
        }
        $temp_excerp =  strip_tags($content);
        $temp_excerp =  strip_shortcodes($temp_excerp);
        $kopa_excerpt = wp_trim_words($temp_excerp, $kopa_length, $more = null);
    }else{
        $kopa_excerpt =  $temp_excerp;
    }

    return $kopa_excerpt;
}

/**
 * Template tag: print breadcrumb
 */
function kopa_breadcrumb() {
    // get show/hide option
    $kopa_breadcrumb_status = get_option('kopa_theme_options_breadcrumb_status', 'show');

    if ( $kopa_breadcrumb_status != 'show' ) {
        return;
    }

    if (is_main_query()) {
        global $post, $wp_query;

        $prefix = '&nbsp;/&nbsp;';
        $current_class = 'current-page';
        $description = '';
        $breadcrumb_before = '<div class="kopa-breadcrumb">';
        $breadcrumb_after = '</div>';
        $breadcrumb_home = '<span class="kopa-brf">'.__('You are here: ', 'new-lotus') .'</span> <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="' . home_url() . '"><span itemprop="title">' . __('Home', 'new-lotus') . '</span></a></span>';
        $breadcrumb = '';
        ?>

    <?php
        if (is_home()) {
            $breadcrumb.= $breadcrumb_home;
            if ( get_option( 'page_for_posts' ) ) {
                $breadcrumb.= $prefix . sprintf('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="%1$s">%2$s</span>', $current_class, get_the_title(get_option('page_for_posts')));
            } else {
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, __('Blog', 'new-lotus'));
            }
        } else if (is_tag()) {
            $breadcrumb.= $breadcrumb_home;

            $term = get_term(get_queried_object_id(), 'post_tag');
            $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, $term->name);
        } else if (is_category()) {
            $breadcrumb.= $breadcrumb_home;

            $category_id = get_queried_object_id();
            $terms_link = explode(',', substr(get_category_parents(get_queried_object_id(), TRUE, ','), 0, (strlen(',') * -1)));
            $n = count($terms_link);
            if ($n > 1) {
                for ($i = 0; $i < ($n - 1); $i++) {
                    $breadcrumb.= $prefix . $terms_link[$i];
                }
            }
            $breadcrumb.= $prefix . sprintf('<span class="%1$s" itemprop="title">%2$s</span>', $current_class, get_the_category_by_ID(get_queried_object_id()));

        } else if (is_single()) {
            $breadcrumb.= $breadcrumb_home;

            if ( get_post_type() === 'product' ) :

                $breadcrumb .= $prefix . '<a href="'.get_page_link( get_option('woocommerce_shop_page_id') ).'">'.get_the_title( get_option('woocommerce_shop_page_id') ).'</a>';

                if ($terms = get_the_terms( $post->ID, 'product_cat' )) :
                    $term = apply_filters( 'jigoshop_product_cat_breadcrumb_terms', current($terms), $terms);
                    $parents = array();
                    $parent = $term->parent;
                    while ($parent):
                        $parents[] = $parent;
                        $new_parent = get_term_by( 'id', $parent, 'product_cat');
                        $parent = $new_parent->parent;
                    endwhile;
                    if(!empty($parents)):
                        $parents = array_reverse($parents);
                        foreach ($parents as $parent):
                            $item = get_term_by( 'id', $parent, 'product_cat');
                            $breadcrumb .= $prefix . '<a href="' . get_term_link( $item->slug, 'product_cat' ) . '">' . $item->name . '</a>';
                        endforeach;
                    endif;
                    $breadcrumb .= $prefix . '<a href="' . get_term_link( $term->slug, 'product_cat' ) . '">' . $term->name . '</a>';
                endif;

                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, get_the_title());

            else :

                $categories = get_the_category(get_queried_object_id());
                if ($categories) {
                    foreach ($categories as $category) {
                        $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', get_category_link($category->term_id), $category->name);
                    }
                }

                $post_id = get_queried_object_id();
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, get_the_title($post_id));

            endif;

        } else if (is_page()) {
            if (!is_front_page()) {
                $post_id = get_queried_object_id();
                $breadcrumb.= $breadcrumb_home;
                $post_ancestors = get_post_ancestors($post);
                if ($post_ancestors) {
                    $post_ancestors = array_reverse($post_ancestors);
                    foreach ($post_ancestors as $crumb)
                        $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', get_permalink($crumb), get_the_title($crumb));
                }
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, get_the_title(get_queried_object_id()));
            }
        } else if (is_year() || is_month() || is_day()) {
            $breadcrumb.= $breadcrumb_home;

            $date = array('y' => NULL, 'm' => NULL, 'd' => NULL);

            $date['y'] = get_the_time('Y');
            $date['m'] = get_the_time('m');
            $date['d'] = get_the_time('j');

            if (is_year()) {
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, $date['y']);
            }

            if (is_month()) {
                $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', get_year_link($date['y']), $date['y']);
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, date_i18n('F', $date['m']));
            }

            if (is_day()) {
                $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', get_year_link($date['y']), $date['y']);
                $breadcrumb.= $prefix . sprintf('<a href="%1$s">%2$s</a>', get_month_link($date['y'], $date['m']), date_i18n('F', $date['m']));
                $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, $date['d']);
            }

        } else if (is_search()) {
            $breadcrumb.= $breadcrumb_home;

            $s = get_search_query();
            $c = $wp_query->found_posts;
            //$count = $wp_query->post_count.'';

            $description = sprintf(__('<span class="%1$s">Your search for "%2$s" return %3$s results</span>', 'new-lotus'), $current_class, $s, $c);
            $breadcrumb .= $prefix . $description;
        } else if (is_author()) {
            $breadcrumb.= $breadcrumb_home;
            $author_id = get_queried_object_id();
            $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, sprintf(__('Posts created by %1$s', 'new-lotus'), get_the_author_meta('display_name', $author_id)));
        } else if (is_404()) {
            $breadcrumb.= $breadcrumb_home;
            $breadcrumb.= $prefix . sprintf('<span class="%1$s">%2$s</span>', $current_class, __('Error 404', 'new-lotus'));
        }

        if ($breadcrumb)
            echo apply_filters('kopa_breadcrumb', $breadcrumb_before . $breadcrumb . $breadcrumb_after);
    }
}

/*
 * Kopa get post format icon
 */
function kopa_get_post_format_icon ($post_id) {
    $post_format = get_post_format();
    if ( false === $post_format ) {
        $post_format = 'standard';
    }
    //vd($post_format);
    switch($post_format){
        case 'standard':
            $fa_icon = 'standard-post';
            break;
        case 'video':
            $fa_icon = 'video-post';
            break;
        case 'audio':
            $fa_icon = 'audio-post';
            break;
        case 'gallery':
            $fa_icon = 'gallery-post';
            break;
        case 'quote':
            $fa_icon = 'quote-post';
            break;
        case 'link':
            $fa_icon = 'link-post';
            break;
    }
    return $fa_icon;
}

/**
 * Get gallery string ids after getting matched gallery array
 * @return array of attachment ids in gallery
 * @return empty if no gallery were found
 */
function kopa_content_get_gallery_attachment_ids( $content ) {
    $gallery = kopa_content_get_gallery( $content );

    if (isset( $gallery[0] )) {
        $gallery = $gallery[0];
    } else {
        return '';
    }

    if ( isset($gallery['shortcode']) ) {
        $shortcode = $gallery['shortcode'];
    } else {
        return '';
    }

    // get gallery string ids
    preg_match_all('/ids=\"(?:\d+,*)+\"/', $shortcode, $gallery_string_ids);
    if ( isset( $gallery_string_ids[0][0] ) ) {
        $gallery_string_ids = $gallery_string_ids[0][0];
    } else {
        return '';
    }

    // get array of image id
    preg_match_all('/\d+/', $gallery_string_ids, $gallery_ids);
    if ( isset( $gallery_ids[0] ) ) {
        $gallery_ids = $gallery_ids[0];
    } else {
        return '';
    }

    return $gallery_ids;
}


function kopa_content_get_gallery($content, $enable_multi = false) {
    return kopa_content_get_media($content, $enable_multi, array('gallery'));
}

function kopa_content_get_audio($content, $enable_multi = false) {
    return kopa_content_get_media($content, $enable_multi, array('audio', 'soundcloud'));
}

function kopa_content_get_video($content, $enable_multi = false) {
    return kopa_content_get_media($content, $enable_multi, array('vimeo', 'youtube', 'video', 'embed'));
}

function kopa_content_get_media($content, $enable_multi = false, $media_types = array()) {
    $media = array();
    $regex_matches = '';
    $regex_pattern = get_shortcode_regex();
    preg_match_all('/' . $regex_pattern . '/s', $content, $regex_matches);
    foreach ($regex_matches[0] as $shortcode) {
        $regex_matches_new = '';
        preg_match('/' . $regex_pattern . '/s', $shortcode, $regex_matches_new);
        if (in_array($regex_matches_new[2], $media_types)) :
            $media[] = array(
                'shortcode' => $regex_matches_new[0],
                'type' => $regex_matches_new[2],
                'url' => $regex_matches_new[5]
            );
            if (false == $enable_multi) {
                break;
            }
        endif;
        //vd($media);
    }    return $media;
}

/*
 * Remove dimension of post thumbnail
 */
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );
function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}


/*
kopa set view count
 */

function kopa_set_view_count($post_id) {
    $new_view_count = 0;
    $meta_key = 'kopa_' . 'new-lotus' . '_total_view';

    $current_views = (int) get_post_meta($post_id, $meta_key, true);

    if ($current_views) {
        $new_view_count = $current_views + 1;
        update_post_meta($post_id, $meta_key, $new_view_count);
    } else {
        $new_view_count = 1;
        add_post_meta($post_id, $meta_key, $new_view_count);
    }
    return $new_view_count;
}
function kopa_footer() {
    wp_nonce_field('kopa_set_view_count', 'kopa_set_view_count_wpnonce', false);
}

function kopa_social_links() {
    $social_links = kopa_get_socials();

    foreach( $social_links as $social_name => $social_atts ) {
        $option_name = $social_atts['id'] . '_url';
        $social_atts['url'] = kopa_get_option( $option_name);

        if ( 'rss' == $social_atts['id'] ) {
            if ( empty( $social_atts['url'] ) ) {
                $social_atts['url'] = get_bloginfo('rss2_url');
                $social_atts['display'] = true;
            } elseif ( $social_atts['url'] != 'HIDE' ) {
                $social_atts['url'] = esc_url( $social_atts['url'] );
                $social_atts['display'] = true;
            }
        } else {
            $social_atts['url'] = esc_url( $social_atts['url'] );
            if ( !empty( $social_atts['url'] ) ) { $social_atts['display'] = true; }
        }

        $social_links[ $social_name ] = $social_atts;
    }

    $social_link_target = kopa_get_option( 'social_link_target', '_self' );
    ?>
    <ul class="list-unstyled">
        <?php foreach ( $social_links as $social_name => $social_atts) { ?>
            <?php if ( $social_atts['display'] ) { ?>
            <li><a href="<?php echo esc_url($social_atts['url']); ?>" class="fa fa-<?php echo esc_attr($social_atts['id']); ?>" target="<?php echo esc_attr($social_link_target); ?>" rel="nofollow"></a></li>
            <?php } // endif ?>
        <?php } // endforeach ?>
    </ul>
    <?php
}


function widget_categories_args_filter( $cat_args ) {
	$cat_args['number']=10;
	return $cat_args;
}

add_filter( 'widget_categories_args', 'widget_categories_args_filter');

function kopa_the_tag($post_id = 0){
    $curr_tags = wp_get_post_tags($post_id);
    if ('show' === get_option('tag_status', 'show')){
        if (count($curr_tags) > 12){
            the_tags( '<div class="kopa-tags kopa-tags-below"><span>' . __( 'Tags: ', 'new-lotus' ) . ' </span>', ', ', '</div>' );
        }else{
            the_tags( '<div class="kopa-tags"><span>' . __( 'Tags: ', 'new-lotus' ) . ' </span>', ', ', '</div>' );
        }
    }
}
/*
 * post navigation
 */
function kopa_post_navigation(){
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    if ( 'show' === get_option('navigation_status', 'show') && ( get_next_post() || get_previous_post() ) ){ ?>
        <ul class="pager-page list-unstyled clearfix">
            <?php if (!empty( $prev_post )){ ?>
            <li class="prev-post pull-left">
                <h4 class="prev"><i class="fa fa-angle-double-left"></i><a href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>" ><?php echo __('Previous article', 'new-lotus');?></a></h4>
                <h4 class="prev-post-title"><a href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>"><?php echo esc_html($prev_post->post_title); ?></a></h4>
                <span class="post-meta">
                    <span class="post-date"><?php echo get_the_time( get_option('date_format'), $prev_post->ID ); ?></span>
                    <span class="post-author"><?php _e('By', 'new-lotus'); ?> <a href="<?php echo esc_url(get_author_posts_url($prev_post->post_author)); ?>"><?php the_author_meta('display_name',$prev_post->post_author) ?></a></span>
                </span>
            </li>
            <?php } ?>
            <?php if (!empty( $next_post )){ ?>
            <li class="next-post pull-right">
                <h4 class="next"><a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo __('Next Article', 'new-lotus');?></a><i class="fa fa-angle-double-right"></i></h4>
                <h4 class="next-post-title"><a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo esc_html($next_post->post_title);?></a></h4>
                <span class="post-meta">
                    <span class="post-date"><?php echo get_the_time( get_option('date_format'), $next_post->ID ); ?></span>
                    <span class="post-author"><?php _e('By', 'new-lotus'); ?> <a href="<?php echo esc_url(get_author_posts_url($next_post->post_author)); ?>"><?php the_author_meta('display_name',$next_post->post_author) ?></a></span>
                </span>
            </li>
            <?php } ?>
        </ul>

<?php } 
}

function kopa_related_articles() {
    if (is_single()) {
        $get_by = kopa_get_option('post_get_by');
        if ('hide' != $get_by) {
            $limit = (int) kopa_get_option('post-relate-limit');
            if ($limit > 0) {
                global $post;
                $taxs = array();
                if ('category' == $get_by) {
                    $cats = get_the_category(($post->ID));
                    if ($cats) {
                        $ids = array();
                        foreach ($cats as $cat) {
                            $ids[] = $cat->term_id;
                        }
                        $taxs [] = array(
                            'taxonomy' => 'category',
                            'field' => 'id',
                            'terms' => $ids
                        );
                    }
                } else {
                    $tags = get_the_tags($post->ID);
                    if ($tags) {
                        $ids = array();
                        foreach ($tags as $tag) {
                            $ids[] = $tag->term_id;
                        }
                        $taxs [] = array(
                            'taxonomy' => 'post_tag',
                            'field' => 'id',
                            'terms' => $ids
                        );
                    }
                }

                if ($taxs) {
                    $related_args = array(
                        'tax_query' => $taxs,
                        'post__not_in' => array($post->ID),
                        'posts_per_page' => $limit
                    );
                    $related_posts = new WP_Query( $related_args );
                    if ( $related_posts->have_posts() ) { ?>
                        <div class="widget kopa-relatedpost pull-right">
                            <div class="widget-header">
                                <span class="font-heading"><?php _e('post by related','new-lotus'); ?></span>
                                <h3 class="widget-title"><?php  _e('related post','new-lotus'); ?></h3>
                            </div>
                            <div class="widget-content">
                                <ul class="list-unstyled">
                                    <?php 
                                    while ( $related_posts->have_posts() ) { 
                                        $related_posts->the_post();
                                        ?>
                                        <li class="item">
                                            <a href="<?php the_permalink(); ?>" class="post-thumb">
                                                <?php 
                                                
                                                if(has_post_thumbnail()){
                                                    echo kopa_the_image(get_the_ID(),get_the_title(),60,60,true);
                                                } elseif('yes' === get_option('kopa_theme_options_thumbnail_status', 'yes')) {
                                                    echo '<img src="'.get_template_directory_uri().'/images/sample/sample_60x60.gif" alt="no thumbnail">';
                                                } 
                                                ?>
                                            </a>
                                            <div class="item-right post-caption">
                                                    <?php
                                                        $post_relate= kopa_get_option('post-relate-date-status');
                                                        if('1'===$post_relate){ ?>
                                                        <span class="post-meta"><span class="post-date"><?php echo get_the_date(get_option('date_format'));  ?></span></span>
                                                    <?php }?>
                                                <h4 class="post-title">
                                                    <a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
                                                </h4>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                    } // endif
                    wp_reset_postdata();
                }
            }
        }
    }
}