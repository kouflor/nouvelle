<?php
/**
 * Extra for theme options settings
 */
add_filter('kopa_theme_options_settings', 'kopa_extra_theme_options_settings');

function kopa_extra_theme_options_settings($options) {
    // General settings
    $options[] = array(
        'title' => __('General Settings', 'new-lotus'),
        'type' => 'title',
        'desc' => '',
        'id' => 'general',
        'icon' => 'home'
    );
    // start group: logo, favicon, apple icon
    $options[] = array(
        'title' => __('Logo,Favicon, Apple Icon', 'new-lotus'),
        'id' => 'base-group',
        'type' => 'groupstart',
    );

    // logo
    $options[] = array(
        'title' => __('Logo', 'new-lotus'),
        'type' => 'upload',
        'id' => 'logo_url',
        'desc' => __('Upload your logo', 'new-lotus'),
        'class' => "kopa_extra_class",
        'mimes' => 'image',
    );
    $options[] = array(
        'title' => __('Logo margin top', 'new-lotus'),
        'type' => 'number',
        'id' => 'logo_margin_top',
        'desc' => __('Logo margin top', 'new-lotus'),
        'class' => "kopa_extra_class",
    );
    $options[] = array(
        'title' => __('Logo margin left', 'new-lotus'),
        'type' => 'number',
        'id' => 'logo_margin_left',
        'desc' => __('Logo margin left', 'new-lotus'),
        'class' => "kopa_extra_class",
        
    );

    // favicon
    $options[] = array(
        'title' => __('Favicon', 'new-lotus'),
        'type' => 'upload',
        'id' => 'favicon_url',
        'desc' => __('Upload your favicon', 'new-lotus'),
        'class' => "kopa_extra_class",
        'mimes' => 'image',
    );
    // Iphone (57px - 57px)
    $options[] = array(
        'title' => __('Apple icon', 'new-lotus'),
        'type' => 'upload',
        'id' => 'apple_iphone_icon_url',
        'desc' => __('Iphone (57px - 57px)', 'new-lotus'),
        'class' => "kopa_extra_class",
        'mimes' => 'image',
    );
    // Iphone Retina (114px - 114px)
    $options[] = array(
        'title' => '',
        'type' => 'upload',
        'id' => 'apple_iphone_retina_icon_url',
        'desc' => __('Iphone Retina (114px - 114px)', 'new-lotus'),
        'class' => "kopa_extra_class",
        'mimes' => 'image',
    );
    // Ipad (72px - 72px)
    $options[] = array(
        'title' => '',
        'type' => 'upload',
        'id' => 'apple_ipad_icon_url',
        'desc' => __('Ipad (72px - 72px)', 'new-lotus'),
        'class' => "kopa_extra_class",
        'mimes' => 'image',
    );
    // Ipad Retina (144px - 144px)
    $options[] = array(
        'title' => '',
        'type' => 'upload',
        'id' => 'apple_ipad_retina_icon_url',
        'desc' => __('Ipad Retina (144px - 144px)', 'new-lotus'),
        'class' => "kopa_extra_class",
        'mimes' => 'image',
    );

    // end group
    $options[] = array(
        'type' => 'groupend',
        'id' => 'base-group',
    );

    // start group: config header
    $options[] = array(
        'title' => __('Config header', 'new-lotus'),
        'id' => 'header-group',
        'type' => 'groupstart',
    );

    $options[] = array(
        'title' => __('Date', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('Show / Hide date', 'new-lotus'),
        'id' => 'date_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );

    $options[] = array(
        'title' => __('Top menu', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('Show / Hide top menu', 'new-lotus'),
        'id' => 'topmenu_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    
    $options[] = array(
        'title' => __('Search', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('Show / Hide search', 'new-lotus'),
        'id' => 'search_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    
    // end group
    $options[] = array(
        'type' => 'groupend',
        'id' => 'header-group',
    );

    // start group: responsive
    $options[] = array(
        'title' => __('Responsive layout', 'new-lotus'),
        'id' => 'responsive-group',
        'type' => 'groupstart',
    );
    $options[] = array(
        'title' => '',
        'type' => 'radio',
        'desc' => __('Enable / Disable responsive layout', 'new-lotus'),
        'id' => 'responsive_status',
        'default' => 1,
        'options' => array(
            '1' => __('Enable', 'new-lotus'),
            '2' => __('Disable', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );

    // end group
    $options[] = array(
        'type' => 'groupend',
        'id' => 'responsive-group',
    );


    // start group: footer
    $options[] = array(
        'title' => __('Footer', 'new-lotus'),
        'id' => 'footer-group',
        'type' => 'groupstart',
    );
    $options[] = array(
        'title' => __('Custom footer description', 'new-lotus'),
        'type' => 'textarea',
        'desc' => __('Enter the content you want to display in your footer (e.g. copyright text).', 'new-lotus'),
        'id' => 'copyright',
        'default' => __('Copyright 614 - Kopasoft. All Rights Reserved.', 'new-lotus'),
        'class' => 'kopa_extra_class',
        'css' => '',
    );
    // end group
    $options[] = array(
        'type' => 'groupend',
        'id' => 'footer-group',
    );


    // start group: system
    $options[] = array(
        'title' => __('Content post', 'new-lotus'),
        'id' => 'meta-group',
        'type' => 'groupstart',
    );
    $options[] = array(
        'title' => __('Date', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('Show / Hide', 'new-lotus'),
        'id' => 'post_meta_date_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    $options[] = array(
        'title' => __('Author', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('Show / Hide', 'new-lotus'),
        'id' => 'post_meta_author_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    $options[] = array(
        'title' => __('Read more', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('Show / Hide', 'new-lotus'),
        'id' => 'post_readmore_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );

    // end group
    $options[] = array(
        'type' => 'groupend',
        'id' => 'meta-group',
    );


    // start group: system
    $options[] = array(
        'title' => __('System', 'new-lotus'),
        'id' => 'system-group',
        'type' => 'groupstart',
    );
    $options[] = array(
        'title' => __('Breadcrumb', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('Show / Hide breadcrumb', 'new-lotus'),
        'id' => 'breadcrumb_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    
    $options[] = array(
        'title' => __('Thumbnail', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('Show / Hide thumbnail', 'new-lotus'),
        'id' => 'blog_thumbnail_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );


    $options[] = array(
        'title' => __('Excerpt words limit for front page', 'new-lotus'),
        'type' => 'number',
        'desc' => __('Custom excerpt length for front page', 'new-lotus'),
        'id' => 'excerpt_blog',
        'default' => 55,
        'class' => 'kopa_extra_class',
    );

    // end group
    $options[] = array(
        'type' => 'groupend',
        'id' => 'system-group',
    );


    // Post setting
    $options[] = array(
        'title' => __('Post Settings', 'new-lotus'),
        'type' => 'title',
        'desc' => '',
        'id' => 'post',
        'icon' => 'filter'
    );

    $options[] = array(
        'title' => __('Show/hide thumbnail:', 'new-lotus'),
        'type' => 'radio',
        'desc' => '',
        'id' => 'post_thumbnail_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    $options[] = array(
        'title' => __('Show/hide date:', 'new-lotus'),
        'type' => 'radio',
        'desc' => __('', 'new-lotus'),
        'id' => 'post_date_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    $options[] = array(
        'title' => __('Show/hide author:', 'new-lotus'),
        'type' => 'radio',
        'desc' => '',
        'id' => 'post_author_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );

    $options[] = array(
        'title' => __('Show/hide tags:', 'new-lotus'),
        'type' => 'radio',
        'desc' => '',
        'id' => 'post_tag_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    $options[] = array(
        'title' => __('Show/hide navigation:', 'new-lotus'),
        'type' => 'radio',
        'desc' => '',
        'id' => 'post_navigation_status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );

    // start group: related post
    $options[] = array(
        'title' => __('Related Posts', 'new-lotus'),
        'id' => 'related-post-group',
        'type' => 'groupstart',
    );

    $options[] = array(
        'title' => __('Get by', 'new-lotus'),
        'type' => 'select',
        'desc' => '',
        'id' => 'post_get_by',
        'default' => '2',
        'options' => array(
            'hide' => __('-- Hiden --', 'new-lotus'),
            'post_tag' => __('Tag', 'new-lotus'),
            'category' => __('Category', 'new-lotus')
        ),
        'class' => 'kopa_extra_class',
        'css' => '',
    );

    $options[] = array(
        'title' => __('Limit', 'new-lotus'),
        'type' => 'number',
        'id' => 'post-relate-limit',
        'default' => 6,
        'class' => 'kopa_extra_class',
    );
    $options[] = array(
        'title' => __('Show/hide date:', 'new-lotus'),
        'type' => 'radio',
        'desc' => '',
        'id' => 'post-relate-date-status',
        'default' => 1,
        'options' => array(
            '1' => __('Show', 'new-lotus'),
            '2' => __('Hide', 'new-lotus'),
        ),
        'class' => 'kopa_extra_class',
        'css' => ''
    );
    
    // end group
    $options[] = array(
        'type' => 'groupend',
        'id' => 'related-post-group',
    );

    return $options;
}
